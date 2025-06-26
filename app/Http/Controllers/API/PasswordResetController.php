<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    // link send code via email
    public function sendResetLink(Request $request)
    {
        //dd('okk');
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);
        //dd($request->all());
        //$data = $ 
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $status = Password::sendResetLink($request->only('email'));

        $customMessages = [
                Password::RESET_LINK_SENT => "Your password reset link send to your this ($request->email) email address",
                Password::INVALID_USER => 'Somethings went wrong!'
            ];

            return response()->json([
                'success' => $status === Password::RESET_LINK_SENT,
                'message' => $customMessages[$status] ?? __($status)
            ], $status === Password::RESET_LINK_SENT ? 200 : 400);
    }

    public function showResetData(Request $request)
    {
        return response()->json([
            'token' => $request->token,
            'email' => $request->email, 
        ]);
    }

    public function resetPassword(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
                event(new PasswordReset($user));
            }
        );

        return response()->json([
            'success' => $status === Password::PASSWORD_RESET,
            'message' => __($status)
        ], $status === Password::PASSWORD_RESET ? 200 : 400);
    }


} // End class
