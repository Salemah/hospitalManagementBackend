<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    public function registersubmit(Request $req)
    {

        $validator = Validator::make(
            $req->all(),

            [
                'name' => 'required|min:4|max:20',
                'email' => 'required|email',
                'password' => 'required|min:6',
                'confirmpassword' => 'required|same:password',
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|max:14|min:11',

            ],
            [
                'phone.required' => 'Phone is required!',
                'phone.regex' => 'Invalid phone number!',
                'phone.max' => 'Number should 11 characters!',
                'confirmpassword.same' => 'password missmatched'

            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {

            $email = $req->email;
            $phone = $req->phone;


            $userEmail = User::where([['email', '=', $email]])->first();
            $userPhone = User::where([['phone', '=', $phone]])->first();

            if ($userEmail && $userPhone) {
                return response()->json([
                    'duplicate' => 'Email and phone already taken! use another one!',
                ]);
            } else if ($userEmail) {
                return response()->json([
                    'duplicateEmail' => 'Email already taken! use another one!',
                ]);
            } else if ($userPhone) {
                return response()->json([
                    'duplicatePhone' => 'Phone Number already taken! use another one!',
                ]);
            } else {
                $user = new User();
                $user->name = $req->name;
                $user->usertype =  $req->usertype;
                $user->email = $req->email;
                $user->phone = $req->phone;
                $user->password = $req->password;
                $user->save();
            }
            if ($user->usertype == 'patient') {
                $patient = new Patient();
                $patient->name = $req->name;
                $patient->userId = $user->id;
                $patient->email = $req->email;
                $patient->phone = $req->phone;
                $patient->save();
                return response()->json([
                    'success' => 'Registration Successful',
                ]);
            }
            else if ($user->usertype == 'admin') {
                $admin = new Admin();
                $admin->name = $req->name;
                $admin->userId = $user->id;
                $admin->email = $req->email;
                $admin->phone = $req->phone;
                $admin->save();
                return response()->json([
                    'success' => 'Registration Successful',
                ]);
            }
            else if ($user->usertype == 'doctor') {
                $doctor = new Doctor();
                $doctor->name = $req->name;
                $doctor->userId = $user->id;
                $doctor->email = $req->email;
                $doctor->phone = $req->phone;
                $doctor->department = $req->department;
                $filename =time().'.'.$req->image->extension();
                 $req->image->move(public_path('images'), $filename);
                $path="$filename";
                $doctor->image = $path;

                $doctor->save();

                return response()->json([
                    'success' => 'Registration Successful',
                ]);
            }



            else {
                return response()->json([
                    'validation_errors' => $validator->errors(),
                ]);
            }
        }
    }
}
