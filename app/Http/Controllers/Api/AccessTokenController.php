<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokenController extends Controller
{
    /**
     * Handle user login and issue an access token
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'device_name' => ['string'],
        ]);
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $deviceName = $request->post('device_name', $request->userAgent());
            $token = $user->createToken($deviceName, ['*'])->plainTextToken;
            return Response::json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 201);
        }
        return Response::json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    /**
     * Logout the user and revoke tokens
     */
    public function destroy($token = null)
    {
        $user = Auth::guard('sanctum')->user();

        if (null === $token) {
            $user->currentAccessToken()->delete();
            return response()->json([
                'message' => 'No active token found'
            ], 404);
        }




        // Revoke the current token
        $PersonalAccessToken = PersonalAccessToken::findToken($token);
        if (
            $user->id == $PersonalAccessToken->tokenable_id
            && get_class($user) == $PersonalAccessToken->tokenable_type
        ) {

            $PersonalAccessToken->delete();
        }
        return response()->json([
            'message' => 'Token revoked successfully'
        ]);
    }
}
