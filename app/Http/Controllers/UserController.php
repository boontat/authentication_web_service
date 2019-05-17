<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Auth as Auth;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Register a new user
     *
     * @param Request $request
     * @return Response
     */
    public function register(Request $request)
    {
        // validate register request
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        // block when validator check failed
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $data = [];
        $data['first_name'] = $request->input('first_name');
        $data['last_name'] = $request->input('last_name');
        $data['email'] = $request->input('email');
        $data['password'] = $request->input('password');
        $data['age'] = $request->input('age');

        $user = User::create($data);

        // $message = 'User created';

        return response()->json(
            ['user'=> [
                'id' => $user->id,
                'email' => $user->email
            ]],
            201 // created
        );

    }

    /**
     * Login user
     *
     * @param Request $request
     * @return Response
     */
    public function login (Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (empty($user)) {
            return response()->json(
                ['error'=>'Email not found'],
                401
            );
        }

        if(Hash::check($request->input('password'), $user->password)){
            $token =  $user->createToken('authentication_api')-> accessToken;

            return response()->json(
                [
                    'user' => $user,
                    'access_token' => $token

                ],
                '200'
            );
        } else{
            return response()->json(
                ['error'=>'Invalid password'],
                401
            );
        }
    }

    /**
     * Get user details
     *
     * @return void
     */
    public function usersDetails()
    {
        $user = Auth::user();
        return response()->json(
            ['user' => $user],
            200
        );
    }
}
