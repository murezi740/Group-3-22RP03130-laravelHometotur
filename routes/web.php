<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Tutor\DashboardController as TutorDashboardController;
use App\Http\Controllers\Parent\DashboardController as ParentDashboardController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/files', [FileController::class, 'index'])->name('files.index');
        Route::post('/files/{file}/scan', [FileController::class, 'scan'])->name('files.scan');
        Route::delete('/files/{file}', [FileController::class, 'delete'])->name('files.delete');
        
        // Tutor management
        Route::post('/tutors', [AdminDashboardController::class, 'createTutor'])->name('tutors.create');
        Route::put('/tutors/{tutor}', [AdminDashboardController::class, 'updateTutor'])->name('tutors.update');
        Route::delete('/tutors/{tutor}', [AdminDashboardController::class, 'deleteTutor'])->name('tutors.delete');
        
        // Subject management
        Route::post('/subjects', [AdminDashboardController::class, 'createSubject'])->name('subjects.create');
        Route::post('/assignments', [AdminDashboardController::class, 'assignSubject'])->name('assignments.create');
    });

    // Tutor routes
    Route::middleware('role:tutor')->prefix('tutor')->name('tutor.')->group(function () {
        Route::get('/dashboard', [TutorDashboardController::class, 'index'])->name('dashboard');
        Route::post('/contents', [TutorDashboardController::class, 'createContent'])->middleware('upload.limit')->name('contents.create');
        Route::post('/assignments', [TutorDashboardController::class, 'assignToParent'])->name('assignments.create');
        Route::get('/parents', [TutorDashboardController::class, 'viewParents'])->name('parents');
    });

    // Parent routes
    Route::prefix('parent')->name('parent.')->middleware('auth')->group(function () {
        Route::get('/dashboard', [ParentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/subjects/{subject}/content', [ParentDashboardController::class, 'viewSubjectContent'])->name('subjects.content');
        Route::get('/profile', [ParentDashboardController::class, 'profile'])->name('profile');
        Route::put('/profile', [ParentDashboardController::class, 'updateProfile'])->name('profile.update');
    });
});
