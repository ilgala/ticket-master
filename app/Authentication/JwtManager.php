<?php

namespace App\Authentication;

use App\Exceptions\InvalidTokenException;
use App\Models\User;
use App\Services\Contracts\UserService;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonTimeZone;
use DateTimeInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\Validation\Constraint\StrictValidAt;

class JwtManager
{
    public function __construct(
        private readonly UserService $userService,
        private readonly Configuration $configuration
    ) {
    }

    public function userToToken(Authenticatable $user, ?DateTimeInterface $expiresAt = null): Token
    {
        $expiresAt = $expiresAt ?? Carbon::now()->addDay();

        return $this->configuration->builder()
            ->issuedBy('https://example.com')
            ->relatedTo($user->getAuthIdentifier())
            ->issuedAt(CarbonImmutable::now())
            ->expiresAt(CarbonImmutable::make($expiresAt))
            ->canOnlyBeUsedAfter(CarbonImmutable::now())
            ->getToken(
                $this->configuration->signer(),
                $this->configuration->signingKey()
            );
    }

    public function fetchBy(string $identifier): Authenticatable
    {
        $token = $this->configuration->parser()->parse($identifier);
        $valid = $this->configuration->validator()->validate(
            $token,
            new StrictValidAt($this->buildClock())
        );

        if (! $valid) {
            throw new InvalidTokenException('The token is invalid.');
        }

        return $this->userService->find($token->claims()->get('sub'));
    }

    public function byCredentials(array $credentials): Authenticatable
    {
        $user = $this->userService->findBy($credentials['email'], true);
        if (Hash::check($credentials['password'], $user->password)) {
            return $user;
        }

        throw new ModelNotFoundException('User not found');
    }

    private function buildClock(): SystemClock
    {
        return new SystemClock(new CarbonTimeZone(
            config('app.timezone', 'UTC')
        ));
    }
}
