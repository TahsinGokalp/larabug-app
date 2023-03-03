<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterFcmTokenRequest;
use App\Http\Resources\Api\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request)
    {
        return new UserResource($request->user());
    }

    public function registerFcmToken(RegisterFcmTokenRequest $request)
    {
        return $request->user('api')->fcmTokens()->create([
            'token'  => $request->input('token'),
            'device' => $request->input('device'),
        ]);
    }
}
