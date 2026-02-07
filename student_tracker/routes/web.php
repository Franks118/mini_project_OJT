<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentsController;

Route::get('/', function () {
    return view('welcome');
});

// Route::controller(StudentsController::class)->group(function () {
//     Route::post('/student/save', 'save');
//     Route::get('/student/get', 'get');
//     Route::put('/student/update/{id}', 'update');
//     Route::delete('/student/delete/{id}', 'delete');
// });
