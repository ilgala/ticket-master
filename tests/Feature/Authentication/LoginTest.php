<?php

namespace Tests\Feature\Authentication;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public static function emailProvider(): array
    {
        return [
            ['email', null],
            ['email', true],
            ['email', false],
            ['email', 123],
            ['email', 123.123],
            ['email', ['foo', 'bar']],
            ['email', 'not-an-email'],
            ['email', 'not-an-existing@email.com'],
        ];
    }

    public static function passwordProvider(): array
    {
        return [
            ['password', null],
            ['password', true],
            ['password', false],
            ['password', 123],
            ['password', 123.123],
            ['password', ['foo', 'bar']],
            ['password', 'foo'],
        ];
    }

    public function testAuthenticatedUserIsNotAuthorized()
    {
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->withToken(JWTAuth::fromUser($user))
            ->postJson(route('login'));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'message' => 'User is already authenticated.',
        ]);
    }

    /**
     * @dataProvider emailProvider
     * @dataProvider passwordProvider
     */
    public function testRequestIsValid(string $input, mixed $value)
    {
        $response = $this->postJson(route('login'), [
            $input => $value,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors($input);
    }

    public function testRequestSucceeds()
    {
        $user = User::factory()->create();
        $response = $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'token', 'expiresIn', 'type',
            ],
        ]);
    }
}
