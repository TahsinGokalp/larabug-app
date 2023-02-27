<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;

class FcmController extends Controller
{
    public function index()
    {
        $tokens = auth()->user()->fcmTokens()->get();

        return inertia('Profile/FcmTokens/Index', [
            'tokens' => $tokens,
        ]);
    }

    public function destroy($id)
    {
        auth()->user()->fcmTokens()->findOrFail($id)->delete();

        return redirect()->route('panel.profile.fcm-tokens.index')->with('success', 'Token has been removed');
    }
}
