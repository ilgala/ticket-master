<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Services\Contracts\AuthenticationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogoutController extends Controller
{
    public function __construct(
        private readonly AuthenticationService $authenticationService
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->authenticationService->logout();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
