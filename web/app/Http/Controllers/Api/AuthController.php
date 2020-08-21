<?php
/*
 * MIT License
 *
 * Copyright (c) 2020 Leon-Salas-Santander
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
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
                'error' => ['Correo o contraseña incorrecta'],
                'message' => 'Unauthorized, wrong email or password',
            ]);
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
