<?php

// use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Job_ApllicationsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Job_VacancyController;
use Illuminate\Support\Facades\Mail;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth','role:job-seeker'])->group(function () {
    Route::get('job_application',[Job_ApllicationsController::class,'index'])->name('job_applications.index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/jobs/{id}', [Job_VacancyController::class, 'show'])->name('job_vacancy.show');
    Route::get('/jobs/{id}/apply', [Job_VacancyController::class, 'apply'])->name('job_vacancy.apply');
    Route::post('/jobs/{id}/apply', [Job_VacancyController::class, 'processApply'])->name('job_vacancy.processApply');
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');





});

require __DIR__.'/auth.php';
