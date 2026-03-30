<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TernslotController;
use App\Http\Controllers\TimeslotController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function(){
    Route::get('/user','index');
    Route::post('/register','store');
    Route::post('/login','login');
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // API Resources map to index, store, show, update, destroy correctly
    // replacing the manual 4 routes for each endpoint.
    Route::apiResource('/admin/course', CourseController::class)->parameters(['course' => 'id']);
    Route::apiResource('/admin/timeslots', TimeslotController::class)->parameters(['timeslots' => 'id']);
    Route::apiResource('/admin/ternslot', TernslotController::class)->parameters(['ternslot' => 'id']);
    Route::apiResource('/admin/price', PriceController::class)->parameters(['price' => 'id']);
    Route::apiResource('/admin/enrollment', EnrollmentController::class)->parameters(['enrollment' => 'id']);
});

Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
    // Route::get('/user/profile', [UserController::class, 'index']);
});
