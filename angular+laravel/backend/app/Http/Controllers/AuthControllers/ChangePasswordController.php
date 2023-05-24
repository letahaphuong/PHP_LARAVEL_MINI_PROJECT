<?php

namespace App\Http\Controllers\AuthControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function process(ChangePasswordRequest $request)
    {
        return $this->getPasswordResetTableRow($request)->count() > 0 ? $this->changePassword($request) : $this->tokenNotFoundResponse();
    }

    private function getPasswordResetTableRow($request)
    {
        return DB::table('password_reset_tokens')
            ->where([
                'email' => $request->email,
                'token' => $request->resetToken
            ]);
    }

    private function changePassword($request)
    {
        $user = User::whereEmail($request->email)->first();
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        $this->getPasswordResetTableRow($request)->delete();
        return response()->json([
            'data' => 'Password Successfully Changed'
        ], 200);
    }

    private function tokenNotFoundResponse()
    {
        return response()->json([
            'error' => 'Token or Email is incorrect.'
        ], 422);
    }
}
