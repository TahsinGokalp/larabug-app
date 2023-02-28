<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = auth()->user();

            return $this->sendLoginResponse($request, $user);
        }

        return response()->json(['error' => trans('auth.failed')], Response::HTTP_UNAUTHORIZED);
    }

    public function sendLoginResponse(Request $request, User $user): JsonResponse
    {
        $user->last_mobile_login_at = now();
        $user->save();

        return response()->json([
            'user' => new UserResource($user),
            'token' => $user->api_token,
        ], Response::HTTP_OK);
    }

    public function sendFailedLoginResponse($message = 'An error occured.')
    {
        return response([
            'error' => $message,
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
