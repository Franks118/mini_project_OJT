<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\AttendanceRecordsController;

Route::controller(StudentsController::class)->group(function () {
    Route::post('/student/save', 'save');
    Route::get('/student/get', 'get');
    Route::put('/student/update/{id}', 'update');
    Route::delete('/student/delete/{id}', 'delete');
});

Route::controller(AttendanceRecordsController::class)->group(function () {
    Route::post('/attendance/save', 'save');
    Route::get('/attendance/get', 'get');
    Route::get('/attendance/student/{studentId}', 'getByStudent');
    Route::put('/attendance/update/{id}', 'update');
    Route::delete('/attendance/delete/{id}', 'delete');
});
