<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Http\Controllers\baseController as baseController;

class AuthController extends baseController
{
    public function register(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);
		if ($validated->fails()) {
			return $this->fail($validated->errors());
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $data['token']  = $user->createToken('awsalkasem')->accessToken;
        $data['name']=$user->name;
        return $this->success($data,'user register successfully');
    }
    public function login(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
		if ($validated->fails()) {
			return $this->fail($validated->errors());
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
           $data['token']  = $user->createToken('awsalkasem')->accessToken;
            $data['name']=$user->name;
			return $this->success($data,'user login successfully');
        } else {
            return $this->fail( '[please retyoe passowrd or emial] ');
        }
    }
}
