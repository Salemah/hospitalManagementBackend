<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Doctrslot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function AllDoctor(Request $req)

    {

        return Doctor::all();
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
        //return Appointments::all();
        // return Doctrslot::all();
        $user = Doctrslot::where('userId', $req->userId)->get();
        if ($user) {
            return response()->json($user, 200);
        }
        // $st = Doctrslot::where('userId', $req->userId)->get();

        // return response()->json($st, 200);
    }
}
