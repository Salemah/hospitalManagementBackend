<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    public function Myappointment(Request $req)
    {
        $myappointment = Appointment::where('dcId', $req->id)->get();
        return response()->json($myappointment, 200);
    }
    public function UpdateStatus(Request $req)
    {
        $myappointment = Appointment::where('id', $req->id)->first();
        $myappointment->Status = "Complete";
        $myappointment->update();
        if ($myappointment->update()) {
            return response()->json([
                'success' => 'Update Successful',
                'msd' => $myappointment
            ]);
        }
    }
    public function DoctorProfile(Request $req)
    {

        $user = Doctor::where('userId', $req->id)->first();
        if ($user) {
            return response()->json($user, 200);
        }
    }
    public function DoctoreditProfile(Request $req)
    {

        $users = User::where('id', $req->id)->first();

        $validator = Validator::make(
            $req->all(),

            [
                'name' => 'required|min:4|max:20',
                'email' => 'required|email',
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|max:14|min:11',
                'department' => 'required',


            ],
            [
                'phone.required' => 'Phone is required!',
                'phone.regex' => 'Invalid phone number!',
                'phone.max' => 'Number should 11 characters!',


            ]
        );
        // return response()->json([
        //     'success' => 'Update Successful',
        //     'msg'=> $users,

        // ]);
        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),

            ]);
        } else {

            $users->name = $req->name;
            $users->email = $req->email;
            $users->phone = $req->phone;
            $users->update();

            if ($users->usertype == 'doctor') {
                $patient = Doctor::where('userId', $users->id)->first();
                $patient->name = $req->name;
                $patient->email = $req->email;
                $patient->phone = $req->phone;
                $patient->department = $req->department;
                // return response()->json([
                //           'success' => 'Update Successful',
                //             'msd'=> $patient
                //         ]);
                $patient->update();
                if ($patient->update()) {
                    return response()->json([
                        'success' => 'Update Successful',
                        'msd' => $patient
                    ]);
                }
            }
        }
    }
}
