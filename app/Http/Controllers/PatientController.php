<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Doctrslot;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    public function DoctorSlot()

    {

        return Doctrslot::all();
    }
    public function PatientAppointmentsubmit(Request $req)
    {
        $validator = Validator::make(
            $req->all(),

            [
                'patientname' => 'required',
                'patientid' => 'required',
                'doctor' => 'required',
                'dcid' => 'required',
                'time' => 'required',
                'day' => 'required',
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|max:14|min:11',
                'email' => 'required',

            ],
            [
                'phone.regex' => 'Invalid phone number!',
                'phone.max' => 'Number should 11 characters!',
            ]
        );


        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {
            $aptt = new Appointment();
            $aptt->dcId = $req->dcid;
            $aptt->patientId = $req->patientid;
            $aptt->patientname = $req->patientname;
            $aptt->doctor = $req->doctor;
            $aptt->phone = $req->phone;
            $aptt->time = $req->time;
            $aptt->day = $req->day;

            if ($aptt->save()) {
                return response()->json([
                    'success' => 'Appointment Successful.!',
                ]);
            } else {
                return response()->json([
                    'validation_errors' => 'Appointment Failed.!',
                ]);
            }
        }
    }
    //GET ALL MY APPOINMNET API
    public function Myappointment(Request $req)
    {
        $myappointment = Appointment::where('patientId', $req->id)->get();
        return response()->json($myappointment, 200);
    }
    public function PatientAppointmentDelete(Request $req)
    {

        $myappointment = Appointment::where('id', $req->id)->first();
        if ($myappointment->delete()) {
            return response()->json(["success" => " Appointment Delete Succesfull"], 200);
        } else {
            return response()->json(["msg" => "notfound"], 404);
        }
    }

    public function PatientProfile(Request $req)
    {

        $user = Patient::where('userId', $req->id)->first();
        if ($user) {
            return response()->json($user, 200);
        }
    }
    public function PatienteditProfile(Request $req)
    {
        $users = User::where('id', $req->id)->first();

        $validator = Validator::make(
            $req->all(),

            [
                'name' => 'required|min:4|max:20',
                'email' => 'required|email',
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|max:14|min:11',


            ],
            [
                'phone.required' => 'Phone is required!',
                'phone.regex' => 'Invalid phone number!',
                'phone.max' => 'Number should 11 characters!',


            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),

            ]);
        } else {

            $users->name = $req->name;
            $users->email = $req->email;
            $users->phone = $req->phone;
            // return response()->json([
            //          'success' => 'Update Successful',
            //          'msd'=> $users
            //        ]);

        $users->update();

            if (  $users->usertype == 'patient') {
                $patient = Patient::where('userId',$users->id)->first();
                $patient->name = $req->name;
                $patient->email = $req->email;
                $patient->phone = $req->phone;
                // return response()->json([
                //           'success' => 'Update Successful',
                //             'msd'=> $patient
                //         ]);
                $patient->update();
               if( $patient->update()){
                return response()->json([
                    'success' => 'Update Successful',
                   'msd'=> $patient
                ]);
               }
            }



        }
    }
}
