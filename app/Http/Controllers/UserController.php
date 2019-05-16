<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Auth as Auth;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // indicate success status code
    private $successStatus = 200;

    /**
     * Register a new user
     *
     */
    public function register(Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

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
     * @return void
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

    public function details()
    {
        $user = Auth::user();
        return response()->json(
            ['user' => $user],
            200
        );
    }
}
