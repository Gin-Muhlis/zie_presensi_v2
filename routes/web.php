<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\RoleController;
use App\Http\Controllers\Web\StudentController;
use App\Http\Controllers\Web\TeacherController;
use App\Http\Controllers\Web\PresenceController;
use App\Http\Controllers\Web\SessionEndController;
use App\Http\Controllers\Web\PermissionController;
use App\Http\Controllers\Web\ClassStudentController;
use App\Http\Controllers\Web\SessionStartController;
use App\Http\Controllers\Web\StudentAbsenceController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('class-students', ClassStudentController::class);
        Route::resource('presences', PresenceController::class);
        Route::resource('session-ends', SessionEndController::class);
        Route::resource('session-starts', SessionStartController::class);
        Route::resource('students', StudentController::class);
        Route::resource('student-absences', StudentAbsenceController::class);
        Route::resource('teachers', TeacherController::class);
        Route::resource('users', UserController::class);
    });
