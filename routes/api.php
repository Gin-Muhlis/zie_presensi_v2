<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\PresenceController;
use App\Http\Controllers\Api\SessionEndController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\ClassStudentController;
use App\Http\Controllers\Api\SessionStartController;
use App\Http\Controllers\Api\StudentAbsenceController;
use App\Http\Controllers\Api\TeacherSessionEndsController;
use App\Http\Controllers\Api\ClassStudentStudentsController;
use App\Http\Controllers\Api\TeacherSessionStartsController;
use App\Http\Controllers\Api\StudentStudentAbsencesController;
use App\Http\Controllers\Api\TeacherStudentAbsencesController;
use App\Http\Controllers\Api\ClassStudentSessionEndsController;
use App\Http\Controllers\Api\PresenceStudentAbsencesController;
use App\Http\Controllers\Api\ClassStudentSessionStartsController;


/*
|--------------------------------------------------------------------------
| STUDENT API Routes
|--------------------------------------------------------------------------
**/
Route::prefix('student')
->group(function() {
    Route::post('/register', [AuthController::class, 'studentRegister']);
    Route::post('/login', [AuthController::class, 'studentLogin']);

    Route::middleware('auth:sanctum')
    ->group(function () {
        Route::get('/profile', [StudentController::class, 'profile']);
        Route::post('/absence', [StudentController::class, 'studentAbsence']);
        Route::get('/data/absence', [StudentController::class, 'studentAbsenceData']);
    });
});

Route::prefix('teacher')
->group(function() {
    Route::post('/register', [AuthController::class, 'teacherRegister']);
    Route::post('/login', [AuthController::class, 'teacherLogin']);

    Route::middleware('auth:sanctum')
    ->group(function () {
        Route::get('/profile', [TeacherController::class, 'profile']);
    });
});
    
