<?php

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::permanentRedirect('/', '/patient');

Route::controller(PatientController::class)
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/patient', 'index')->name('patient.index');
        Route::get('/patient/create', 'create')->name('patient.create');
        Route::post('/patient', 'store')->name('patient.store');
        Route::get('/patient/{patient}', 'show')->name('patient.show');
        Route::get('/patient/{patient}/edit', 'edit')->name('patient.edit');
        Route::put('/patient/{patient}', 'update')->name('patient.update');
        Route::delete('/patient/{patient}', 'destroy')->name('patient.destroy');
    });

require __DIR__.'/auth.php';
