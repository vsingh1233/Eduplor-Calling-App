<?php

use App\Http\Controllers\LeadBatchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Minimalist Welcome Page (Google Style)
Route::get('/', function () {
    return view('welcome');
});

// Authenticated Routes Group
Route::middleware(['auth', 'verified'])->group(function () {
    
    // ---------------------------------------------------------
    // Account Approval Notice Screen
    // Accessible by logged-in users who are still pending approval
    // ---------------------------------------------------------
    Route::get('/approval', function () {
        if (auth()->user()->is_active) {
            return redirect()->route('dashboard');
        }
        return view('auth.approval');
    })->name('approval.notice');

    // ---------------------------------------------------------
    // Protected Core Application Features
    // Only logged-in AND activated users can cross this barrier
    // ---------------------------------------------------------
    Route::middleware('active')->group(function () {
        
        // Main Dashboard
        Route::get('/dashboard', [LeadBatchController::class, 'index'])->name('dashboard');

        // Lead Batch Management
        Route::post('/batches', [LeadBatchController::class, 'store'])->name('batches.store');
        Route::get('/batches/{batch}', [LeadBatchController::class, 'show'])->name('batches.show');

        // User Profile Settings (Standard Breeze)
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // ---------------------------------------------------------
        // Administrative Control Management
        // Restricted entirely to accounts with the 'admin' role
        // ---------------------------------------------------------
        Route::middleware('role:admin')->group(function () {
            // User List and Creation Actions
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/users', [UserController::class, 'store'])->name('users.store');
            Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
            
            // Toggle User Suspension / Approval Status
            Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        });
    });
});

// Load standard authentication scaffolding routes (Login, Register, Logout, etc.)
require __DIR__.'/auth.php';