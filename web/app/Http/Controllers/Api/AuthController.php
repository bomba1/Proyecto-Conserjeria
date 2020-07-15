<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
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
    public function register(AuthRegisterRequest $request){
        $data = $request->all();

        //The rules of validation
        $validator = Validator::make($data, [
            'name' => 'required|min:3|max:255',
            'email' => 'email:rfc,dns|required|unique:users',
            'password' => 'required|min:8|max:255|confirmed'
        ]);

        //Returns error 412 if validation fails
        if ($validator->fails()) {
            return response([
                'error' => 'Validation Error' ,
                'message' => $validator->errors(),
            ], 412);
        }

        //Apply bcrypt to password(very secure)
        $data['password'] = bcrypt($request->password);

        // Insert the user into the database
        $user = User::create($data);

        // Token created from user
        $authToken = $user->createToken('authToken');

        //Return the token to the user
        return response([
            'user' => $user,
            'token' => $authToken->accessToken,
            'token_expires_at'=> $authToken->token->expires_at,
        ]);
    }

    /**
     * Do the login, returning the access token.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(AuthLoginRequest $request) {

        // All the data from the request
        $data = $request->all();

        $validator = Validator::make($data, [
            'email' => 'email|required',
            'password' => 'required'
        ]);

        // Fail: // Error 412
        if ($validator->fails()) {
            return response([
                'error' => 'Validation Error',
                'message' => $validator->errors(),
            ], 412);
        }

        // Fail: 401 Unauthorized
        if (!auth()->attempt($data)) {
            return response([
                'error' => 'Invalid Credentials',
                'message' => 'Unauthorized, wrong email or password',
            ],401);
        }

        $authToken = auth()->user()->createToken('authToken');

        return response([
            'user' => auth()->user(),
            'token' => $authToken->accessToken,
            'token_expires_at' => $authToken->token->expires_at,
        ]);

    }

    /**
     * Logout user(revoke token).
     * @param Request $request
     */
    public function logout(Request $request){
        $request->user()->token()->revoke();

        return response([
            'message' => 'Succesfully logged out'
        ]);
    }
}
