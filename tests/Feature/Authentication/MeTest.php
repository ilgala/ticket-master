<?php

namespace Tests\Feature\Authentication;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class MeTest extends TestCase
{
    use RefreshDatabase;

    public function testUnauthenticatedUserIsUnauthorized()
    {
        $response = $this->getJson(route('me'));

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
            ->getJson(route('me'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'id', 'email',
            ],
        ]);
    }
}
