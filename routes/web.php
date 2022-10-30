<?php

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::permanentRedirect('/', '/patient');

Route::resource('patient', PatientController::class)
    ->middleware(['auth','verified']);

require __DIR__.'/auth.php';
