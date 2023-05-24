<?php

namespace App\Http\Controllers\AuthControllers;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RestPasswordController extends Controller
{
    public function sendEmail(Request $request)
    {
        $email = $request->email;
        if (!$this->validateEmail($email)) {
            return $this->failedResponse();
        }

        $this->send($email);
        return $this->successResponse();

    }


    public function send($email)
    {
        $token = $this->createToken($email);

        Mail::to($email)->send(new ResetPasswordMail($token));
    }

    public function createToken($email)
    {
        $oldToken = DB::table('password_reset_tokens')->where('email', $email)->first();

        if ($oldToken) {
            return $oldToken;
        }

        $token = Str::random(60);
        $this->saveToken($token, $email);
        return $token;
    }

    public function validateEmail($email)
    {
        return !!User::where('email', $email)->first();
    }

    public function saveToken($token, $email)
    {
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }

    public function failedResponse()
    {
        return response()->json([
            'error' => 'Email do not found onb our database.'
        ], 404);
    }


    public function successResponse()
    {
        return response()->json([
            'data' => 'Reset Email is send successfully, Please check your inbox.'
        ], 200);
    }
}
