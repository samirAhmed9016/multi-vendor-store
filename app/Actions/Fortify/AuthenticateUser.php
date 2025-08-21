<?php

namespace App\Actions\Fortify;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\LoginResponse;


class AuthenticateUser
{
    /**
     * Handle the authentication of a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Fortify\Contracts\LoginResponse
     */
    public function authenticate(Request $request)
    {
        $username = $request->post(config('fortify.username'));
        $password = $request->post('password');
        $user = Admin::where('username', '=', $username)
            ->orWhere('email', '=', $username)
            ->orWhere('phone_number', '=', $username)
            ->first();
        if ($user && Hash::check($password, $user->password)) {
            Auth::guard(config('fortify.guard'))->login($user);

            return $user;
        }
        return false;
    }
}
