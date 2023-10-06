<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){


         $users = User::all();
         return  response([
            'users'=>$users
        ],200);
        }

        public function store(UserRequest $request){


            $data['name']  = $request->name;
            $data['email'] = $request->email;
            $data['password'] = $request->password;
            $data['country'] = $request->country;


            $user= User::create($data);

            return response()->json(
                $user
//                'status' => true,
//                'message' => 'Admin Created Successfully',
//                'user' => $user,
            );

        }


        public function update(UserRequest $request,$id){

//            $user= User::findOrFail($id);
//            $data['name']  =$request->name ? $request->name : $user->name;
//            $data['email'] = $request->email ? $request->email : $user->email;
//            $data['password'] = $request->password ? $request->password : $user->password;
//            $data['country'] = $request->country ? $request->country : $user->country;
//
//
//            $user->update($data);
//                return response()->json([
//                    'status'=>true,
//                    'data'=>$user,
//                    'message' => 'User Updated Successfully',
//                ]);
        }

        public function destroy($id)
        {
            $user = User::findOrFail($id);

                $user->delete();
            return response()->json([
                'status'=>true,
                'message' => 'Request Information deleted Successfully',
            ]);
            }
}

