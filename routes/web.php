<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobVacancyController;
use Illuminate\Support\Facades\Mail;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth','role:job-seeker'])->group(function () {
    Route::get('job_application',[JobApplicationController::class,'index'])->name('job_applications.index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/jobs/{id}', [JobVacancyController::class, 'show'])->name('job_vacancy.show');
    Route::get('/jobs/{id}/apply', [JobVacancyController::class, 'apply'])->name('job_vacancy.apply');
    Route::post('/jobs/{id}/apply', [JobVacancyController::class, 'processApply'])->name('job_vacancy.processApply');



});

require __DIR__.'/auth.php';
