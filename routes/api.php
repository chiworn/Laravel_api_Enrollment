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
use Termwind\Components\Raw;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::controller(AuthController::class)->group(function(){
    Route::get('/user','index');
    Route::post('/register','store');
    Route::post('/login','login');
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // Data Students
    Route::get('/admin/student',[StudentController::class,'index']);
    Route::post('/admin/student',[StudentController::class,'store']);
    Route::get('/admin/student/{id}',[StudentController::class,'show']);
    Route::put('/admin/student/{id}',[StudentController::class,'update']);
    Route::delete('/admin/student/{id}',[StudentController::class,'destroy']);
    // Data Course
    Route::get('/admin/course',[CourseController::class,'index']);
    Route::post('/admin/course',[CourseController::class,'store']);
    Route::get('/admin/course/{id}',[CourseController::class,'show']);
    Route::put('/admin/course/{id}',[CourseController::class,'update']);
    Route::delete('/admin/course/{id}',[CourseController::class,'destroy']);
    //time slot
    Route::get('/admin/timeslots', [TimeslotController::class, 'index']);
    Route::post('/admin/timeslots', [TimeslotController::class, 'store']);
    Route::get('/admin/timeslots/{id}', [TimeslotController::class, 'show']);
    Route::put('/admin/timeslots/{id}', [TimeslotController::class, 'update']);
    Route::delete('/admin/timeslots/{id}', [TimeslotController::class, 'destroy']);
    //term slot
    Route::get('/admin/ternslot', [TernslotController::class, 'index']);
    Route::post('/admin/ternslot', [TernslotController::class, 'store']);
    Route::get('/admin/ternslot/{id}', [TernslotController::class, 'show']);
    Route::put('/admin/ternslot/{id}', [TernslotController::class, 'update']);
    Route::delete('/admin/ternslot/{id}', [TernslotController::class, 'destroy']);
    //price
    Route::get('/admin/price', [PriceController::class, 'index']);
    Route::post('/admin/price', [PriceController::class, 'store']);
    Route::get('/admin/price/{id}', [PriceController::class, 'show']);
    Route::put('/admin/price/{id}', [PriceController::class, 'update']);
    Route::delete('/admin/price/{id}', [PriceController::class, 'destroy']);
    //Enrollment
    Route::get('/admin/enrollment', [EnrollmentController::class, 'index']);
    Route::post('/admin/enrollment', [EnrollmentController::class, 'store']);
    Route::get('/admin/enrollment/{id}', [EnrollmentController::class, 'show']);
    Route::put('/admin/enrollment/{id}', [EnrollmentController::class, 'update']);
    Route::delete('/admin/enrollment/{id}', [EnrollmentController::class, 'destroy']);
    


});
Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
    // Route::get('/user/profile', [UserController::class, 'index']);
});
