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
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('class-students', ClassStudentController::class);

        // ClassStudent Students
        Route::get('/class-students/{classStudent}/students', [
            ClassStudentStudentsController::class,
            'index',
        ])->name('class-students.students.index');
        Route::post('/class-students/{classStudent}/students', [
            ClassStudentStudentsController::class,
            'store',
        ])->name('class-students.students.store');

        // ClassStudent Session Starts
        Route::get('/class-students/{classStudent}/session-starts', [
            ClassStudentSessionStartsController::class,
            'index',
        ])->name('class-students.session-starts.index');
        Route::post('/class-students/{classStudent}/session-starts', [
            ClassStudentSessionStartsController::class,
            'store',
        ])->name('class-students.session-starts.store');

        // ClassStudent Session Ends
        Route::get('/class-students/{classStudent}/session-ends', [
            ClassStudentSessionEndsController::class,
            'index',
        ])->name('class-students.session-ends.index');
        Route::post('/class-students/{classStudent}/session-ends', [
            ClassStudentSessionEndsController::class,
            'store',
        ])->name('class-students.session-ends.store');

        Route::apiResource('presences', PresenceController::class);

        // Presence Student Absences
        Route::get('/presences/{presence}/student-absences', [
            PresenceStudentAbsencesController::class,
            'index',
        ])->name('presences.student-absences.index');
        Route::post('/presences/{presence}/student-absences', [
            PresenceStudentAbsencesController::class,
            'store',
        ])->name('presences.student-absences.store');

        Route::apiResource('session-ends', SessionEndController::class);

        Route::apiResource('session-starts', SessionStartController::class);

        Route::apiResource('students', StudentController::class);

        // Student Student Absences
        Route::get('/students/{student}/student-absences', [
            StudentStudentAbsencesController::class,
            'index',
        ])->name('students.student-absences.index');
        Route::post('/students/{student}/student-absences', [
            StudentStudentAbsencesController::class,
            'store',
        ])->name('students.student-absences.store');

        Route::apiResource('student-absences', StudentAbsenceController::class);

        Route::apiResource('teachers', TeacherController::class);

        // Teacher Session Starts
        Route::get('/teachers/{teacher}/session-starts', [
            TeacherSessionStartsController::class,
            'index',
        ])->name('teachers.session-starts.index');
        Route::post('/teachers/{teacher}/session-starts', [
            TeacherSessionStartsController::class,
            'store',
        ])->name('teachers.session-starts.store');

        // Teacher Session Ends
        Route::get('/teachers/{teacher}/session-ends', [
            TeacherSessionEndsController::class,
            'index',
        ])->name('teachers.session-ends.index');
        Route::post('/teachers/{teacher}/session-ends', [
            TeacherSessionEndsController::class,
            'store',
        ])->name('teachers.session-ends.store');

        // Teacher Student Absences
        Route::get('/teachers/{teacher}/student-absences', [
            TeacherStudentAbsencesController::class,
            'index',
        ])->name('teachers.student-absences.index');
        Route::post('/teachers/{teacher}/student-absences', [
            TeacherStudentAbsencesController::class,
            'store',
        ])->name('teachers.student-absences.store');

        Route::apiResource('users', UserController::class);
    });
