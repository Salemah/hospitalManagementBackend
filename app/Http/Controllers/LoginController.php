<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function verify(Request $req)
    {
        $validator = Validator::make(
            $req->all(),
            [
                'email' => 'required|email',
                'password' => 'required|min:6',


            ],
            [
                'email.email' => 'Invalid email address!',
                'password.required' => 'Password is required!',

            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {

            $user = User::where('email', $req->email)
                ->where('password', $req->password)->first();
            if ($user) {
                if ($user->usertype == "admin") {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Login Successfully',
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'usertype' => $user->usertype,
                        'username' => $user->username,


                    ]);
                }
               else if ($user->usertype == "doctor") {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Login Successfully',
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'usertype' => $user->usertype,
                        'username' => $user->username,


                    ]);
                }
                else if ($user->usertype == "patient") {
                    $patient = Patient::where('userId', $user->id)->first();
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Login Successfully',
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'userId' =>  $patient->userId,
                        'usertype' => $user->usertype,



                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'notFound',
                    'message' => 'User not Found',
                ]);
            }
        }
    }
    public function loggedOut(Request $req)
    {

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully!'
        ]);
    }
}
