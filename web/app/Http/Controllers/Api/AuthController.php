<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\User;
use Illuminate\Http\Request;

/**
 * Class AuthController
 * @package App\Http\Controllers\Api
 */
class AuthController extends Controller
{
    /**
     * Register an User into the system
     * @param AuthRegisterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function register(AuthRegisterRequest $request){
        $data = $request->all();

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
     * @param AuthLoginRequest $request
     * @return \Illuminate\Http\Response
     */
    public function login(AuthLoginRequest $request) {

        // All the data from the request
        $data = $request->all();

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
            'message' => 'Successfully logged out'
        ]);
    }
}
