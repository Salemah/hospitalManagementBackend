<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Doctrslot;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function AllDoctor(Request $req)

    {
      return Doctor::all();
    }
    public function AllUser(Request $req)

    {
      return User::all();
    }
    public function Allpatient(Request $req)

    {
      return Patient::all();
    }
    public function Allappointment(Request $req)

    {

        return Appointment::all();
    }
    public function DeleteAppointment(Request $req)
    {

        $appointment = Appointment::where('id', $req->id)->first();
        if ($appointment->delete()) {
            return response()->json(["success" => " Appointment Delete Succesfull"], 200);
        } else {
            return response()->json(["msg" => "notfound"], 404);
        }


    }
    public function Doctorslotadd(Request $req)
    {


        $validator = Validator::make(
            $req->all(),

            [

                'userId' => 'required',
                'name' => 'required',
                'day' => 'required',
                'time' => 'required',


            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ]);
        } else {

                $doctorslot = new Doctrslot();
            $doctorslot->name = $req->name;
            $doctorslot->userId = $req->userId;
            $doctorslot->time = $req->time;
            $doctorslot->day = $req->day;


            if ($doctorslot->save()) {
                return response()->json([
                    'success' => 'Slot Add Success',
                ]);
            } else {
                return response()->json([
                    'validation_errors' => $validator->errors()
                ]);
            }
            }
    }
    public function Singledoctorallslot(Request $req)
    {

        $user = Doctrslot::where('userId', $req->userId)->get();
        if ($user) {
            return response()->json($user, 200);
        }

    }
    public function Deletedoctorallslot(Request $req)
    {

        $slot = Doctrslot::where('userId', $req->userId)->first();
        if ($slot->delete()) {
            return response()->json(["success" => " Slot Delete Succesfull"], 200);
        } else {
            return response()->json(["msg" => "notfound"], 404);
        }


    }
    public function PatientApointmentDetails(Request $req)
    {

        $patientallappointment= Appointment::where('patientId', $req->id)->get();
        return response()->json($patientallappointment, 200);


    }
    public function DeletePatient(Request $req)
    {

        $user = User::where('id', $req->id)->first();
        if ($user->delete()) {
            // $patient = Patient::where('id', $req->id)->first();
            return response()->json(["success" => " user Delete Succesfull"], 200);
        } else {
            return response()->json(["msg" => "notfound"], 404);
        }


    }
    public function DeleteDoctor(Request $req)
    {

        $user = User::where('id', $req->id)->first();
        if ($user->delete()) {
            return response()->json(["success" => " Doctor Delete Succesfull"], 200);
        } else {
            return response()->json(["msg" => "notfound"], 404);
        }


    }
}
