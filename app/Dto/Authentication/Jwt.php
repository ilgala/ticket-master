<?php

namespace App\Dto\Authentication;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Override;
use Symfony\Component\HttpFoundation\Response;

readonly class Jwt implements Arrayable, Jsonable, Responsable
{
    public function __construct(
        public string $token,
        public int $expiresIn
    ) {
    }

    #[Override]
    public function toArray(): array
    {
        return [
            'token' => $this->token,
            'expiresIn' => $this->expiresIn,
            'type' => 'Bearer',
        ];
    }

    #[Override]
    public function toJson($options = 0): false|string
    {
        return json_encode($this->toArray(), $options);
    }

    #[Override]
    public function toResponse($request): JsonResponse|Response
    {
        return response()->json([
            'data' => $this->toArray(),
        ]);
    }
}
