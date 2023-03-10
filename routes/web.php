<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::permanentRedirect('/', 'login');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    //Projects
    Route::resource('projects', ProjectController::class);
    Route::get('projects/{id}/installation', [ProjectController::class, 'installation'])->name('projects.installation');
    Route::get('projects/{id}/feedback-installation', [ProjectController::class, 'feedbackInstallation'])->name('projects.feedback-installation');
    Route::post('projects/{id}/test-webhook', [ProjectController::class, 'testWebhook'])->name('projects.test.webhook');
    Route::post('projects/{id}/remove-image', [ProjectController::class, 'removeImage'])->name('projects.remove.image');
    Route::post('projects/{id}/refresh-token', [ProjectController::class, 'refreshToken'])->name('projects.refresh-token');
});
