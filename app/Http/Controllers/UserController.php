<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request as Request;
use App\User;


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

        User::create($data);

        $success['token'] = '';

        return response()->json(['success'=> $success], $this->successStatus);

    }
}
