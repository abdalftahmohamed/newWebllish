<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
class AccessTokenController extends Controller
{ use HasApiTokens;


    public function storeUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $device_name = $request->post('device_name', $request->userAgent());
            $token = $user->createToken($device_name);
            return \Illuminate\Support\Facades\Response::json([
                'token' => $token->plainTextToken,
                'user' => $user,
            ], 201);
        }
        return \Illuminate\Support\Facades\Response::json([
            'code' => 0,
            'message' => 'invaled credentioal'
        ], 401);

    }
}







