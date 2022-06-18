<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
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
Route::get( '/alldoctor', [AdminController::class,'Alldoctor']);
Route::get( '/singledoctorallslot/{userId}', [AdminController::class,'Singledoctorallslot']);
