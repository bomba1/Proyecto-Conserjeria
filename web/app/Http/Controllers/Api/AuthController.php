<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class AuthController
 * @package App\Http\Controllers\Api
 */
class AuthController extends Controller
{
    /**
     * Register an User into the system
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:50',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return response([
                'error' => $validator->errors(),
                'message' => 'Validation Error'
            ]);
        }

        $data['password'] = bcrypt($request->password);

        $user = User::create($data);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([
            'user' => $user,
            'access_token' => $accessToken
        ]);
    }

    /**
     * Do the login, returning the access token.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request) {
        $data = $request->all();

        $validator = Validator::make($data, [
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response([
                'error' => $validator->errors(),
                'message' => 'Validation Error'
            ]);
        }

        if (!auth()->attempt($data)) {
            return response([
                'message' => 'Invalid Credentials'
            ]);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response([
            'user' => auth()->user(),
            'access_token' => $accessToken
        ]);

    }
}
