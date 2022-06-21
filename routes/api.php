<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post( '/registration', [RegistrationController::class,'registersubmit'] );
Route::post('/login', [LoginController::class,'verify'] );
Route::post('/logout', [LoginController::class,'loggedOut'] );
Route::post('/addslot', [AdminController::class,'Doctorslotadd'] );
// all Dector
Route::get('/alluser', [AdminController::class,'AllUser']);
Route::get('/allappointment', [AdminController::class,'Allappointment']);
Route::get('/patientapointmentdetails/{id}', [AdminController::class,'PatientApointmentDetails']);
Route::get( '/alldoctor', [AdminController::class,'Alldoctor']);
Route::post( '/admin/appoinemtntdelete/{id}', [AdminController::class,'DeleteAppointment']);
// Doctor slot
Route::get( '/singledoctorallslot/{userId}', [AdminController::class,'Singledoctorallslot']);
//delete slot
Route::post( '/deletedoctorallslot/{userId}', [AdminController::class,'Deletedoctorallslot']);

//Patient Api
Route::get( '/PatientMyProfile/{id}', [PatientController::class,'PatientProfile'] );
Route::post( '/PatientEditMyProfile', [PatientController::class,'PatienteditProfile'] );
Route::get('/allslot', [PatientController::class,'DoctorSlot']);
Route::post( '/appointmentsubmit', [PatientController::class,'PatientAppointmentsubmit'] );
Route::get('/patient/myappointment/{id}', [PatientController::class,'Myappointment']);

Route::post( '/patient/appointment/delete/{id}', [PatientController::class,'PatientAppointmentDelete'] );

