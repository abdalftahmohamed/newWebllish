<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\NotificationDataResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = auth('api')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
            'country' => 'string',
            'city' => 'string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        }
        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));
        $token = auth('api')->login($user);
        return $this->createNewToken($token);
    }


    public function update(UserRequest $request)
    {
//return $request;
        $user = User::findOrFail($request->id);
        if ($user) {
            $data['name'] = $request->name ? $request->name : $user->name;
            $data['email'] = $request->email ? $request->email : $user->email;
//                $data['password'] = $request->password ? $request->password : $user->password;
            $data['country'] = $request->country ? $request->country : $user->country;
            $data['city'] = $request->city ? $request->city : $user->city;
            $data['type'] = $request->type ? $request->type : $user->type;
            $data['status'] = $request->status ? $request->status : $user->status;
            $user->update($data);
            return response()->json([
                'status' => true,
                'data' => $user,
                'message' => 'User Updated Successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'this id not found please try again',
            ], 404);
        }

    }

    protected function updateProfile(Request $request)
    {
        $id_user = auth('api')->user()->id;

        $user = User::find($id_user);

        $rules = [
            "email" => "email|unique:users,email," . $id_user,
            "password" => "string|confirmed|min:6",
            "country" => "string",
            "city" => "string",
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Check if the old password matches
        if ($request->has('password') && $request->has('old_password')) {
            if (!Hash::check($request->input('old_password'), $user->password)) {
                return response()->json([
                    'status' => false,
                    'en' => 'Old Password Is Incorrect',
                    'ar' => 'كلمة المرور القديمة غير صحيحة',
                ], 502);
            }
            $user->password = bcrypt($request->input('password'));
        }
        // Update the user's information
        $user->name = $request->input('name');
//        $user->email = $request->input('email');
        $user->country_id = $request->input('country_id');
        $user->city_id = $request->input('city_id');
        $user->save();

        return response()->json([
            'status' => true,
            'en' => 'Profile Updated Successfully',
            'ar' => 'تم تحديث الملف الشخصي بنجاح',
            'data' => $user,

        ], 201);
    }

    public function userProfilebyid()
    {
        $user = User::find(auth('api')->user()->id);
        return response()->json([
            'message' => 'true',
            'user' => $user,
        ]);
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }


    public function refresh()
    {
        return $this->createNewToken(auth('api')->refresh());
    }


    public function usersProfile()
    {
//        dd('hghhh');
        return response()->json(auth('api')->user());
    }


    public function allusers()
    {

        $users = User::all();
        return response()->json($users);

    }

    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
//            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user()
        ]);
    }


    public function destroy()
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'this id not found please try again',
            ], 404);
        }
        if ($user->type === 'admin') {
            return response()->json([
                'status' => false,
                'message' => 'This is Admin users cannot be deleted.',
            ], 422);
        }

        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully.',
        ]);
    }

    public function showNotification()
    {
        $user = auth('api')->user();
//        return $user;
        $find = DB::table('notifications')->where('notifiable_id', $user->id);
        if (!$find) {
            return response()->json([
                'status' => false,
                'message' => 'You doesnt have notification',
            ]);

        }
        return response()->json([
            'status' => true,
            'message' => 'You are read All notification',
            'data' => NotificationDataResource::collection($find->get()),
        ]);

    }

    public function readNotification()
    {
        $user = auth('api')->user();
//        return $user;
        $find = DB::table('notifications')
            ->where('notifiable_id', $user->id)
            ->update(['read_at' => now()]);
        if (!$find) {
            return response()->json([
                'status' => false,
                'message' => 'You doesnt have notification',
            ]);

        }
        return response()->json([
            'status' => true,
            'message' => 'You are read All notification',
            'data' => $find,
        ]);

    }

}

