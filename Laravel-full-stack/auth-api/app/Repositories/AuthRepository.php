<?php

namespace App\Repositories;

use App\Interfaces\AuthInterface;
use App\Mail\OtpCodeMail;
use App\Models\OtpCode;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
// use Mail;

class AuthRepository implements AuthInterface
{
    // public function __construct()
    // {
    //     //
    // }

    public function register(array $data)
    {
        // return User::create($data);

        // mofifications added
        User::create($data);

        $otpCode = [
            'email' => $data['email'],
            'code' => rand(111111, 999999),
        ];

        OtpCode::where('email', $data['email'])->delete();
        OtpCode::create($otpCode);

        Mail::to($data['email'])->send(new OtpCodeMail($data['name'], $otpCode['email'], $otpCode['code']));
    }


    public function checkOtpCode(array $data)
    {

        $otpCode = OtpCode::where('email', $data['email'])->first();

        if (!$otpCode)
            return false;

        if (Hash::check($data['code'], $otpCode['code'])) {

            $user = User::where('email', $data['email'])->first();
            $user->update(['is_confirmed' => true]);
            $otpCode->delete();

            $user->token = $user->createToken($user->id)->plainTextToken;

            return $user;
        }

        return false;
    }

    public function login(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user)
            return false;

        if (!Hash::check($data['password'], $user->password)) {
            return false;
        }

        $user->tokens()->delete();
        $user->token = $user->createToken($user->id)->plainTextToken;
        return $user;
    }
}
