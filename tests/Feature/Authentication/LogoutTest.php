<?php

namespace Tests\Feature\Authentication;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticatedUserIsNotAuthorized()
    {
        $response = $this->getJson(route('logout'));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertExactJson([
            'message' => 'Unauthenticated.',
        ]);
    }

    public function testRequestSucceeds()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withToken(JWTAuth::fromUser($user))
            ->postJson(route('logout'));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
