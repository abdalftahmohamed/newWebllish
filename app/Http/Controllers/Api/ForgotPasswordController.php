<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{

    public function forgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $codeInsert = User::where('email', $request->email)->first();
        if (!$codeInsert) {
            return response()->json(['message' => 'Invalid Invalid email address Please try again'], 422);
        }

        $codeInsert->generateCode();

        #send code to notification by Email
        $codeInsert->notify(new ResetPasswordNotification);

//        Mail::to($codeInsert->email)->send(new HelloMail());
        return response()->json([
            'message' => 'User successfully sent code check it',
//            'code' =>$codeInsert->code,
//            'expire_at' =>$codeInsert->expire_at,
        ], 201);
    }


    public function resetPassword(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
            'password' => ['required', 'confirmed', RulesPassword::defaults()],
        ]);
        $currentDate = Carbon::now('Africa/Cairo');

        $user = User::where('code', $request->code)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid verification code. Please try again.']);
        }

        if ($currentDate > $user->expire_at) {
            return response()->json(['message' => 'this code is expire. Please try again.']);
        }

        $user->forceFill([
            'password' => Hash::make($request->password),
            'code' => null,
            'expire_at' => null,
        ])->save();
        return response([
            'message' => 'Password reset successfully'
        ]);
    }


//Email Notification
    public function forgotEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return [
                'status' => __($status)
            ];
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }

    public function resetEmail(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', RulesPassword::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                $user->tokens()->delete();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response([
                'message' => 'Password reset successfully'
            ]);
        }

        return response([
            'message' => __($status)
        ], 500);

    }

}
