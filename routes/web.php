<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExceptionController;
use App\Http\Controllers\IssuesController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::permanentRedirect('/', 'login');

Route::get('exception/{exception:publish_hash}', [DashboardController::class, 'exception'])->name('public.exception');

Route::get('scripts/feedback', [ProjectController::class, 'script'])->name('feedback.script');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    //Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    //Projects
    Route::resource('projects', ProjectController::class);
    Route::get('projects/{id}/installation', [ProjectController::class, 'installation'])->name('projects.installation');
    Route::post('projects/{id}/refresh-token', [ProjectController::class, 'refreshToken'])->name('projects.refresh-token');
    //Exceptions
    Route::delete('projects/{id}/exceptions/delete-all', [ExceptionController::class, 'deleteAll'])->name('exceptions.delete-all');
    Route::post('projects/{id}/exceptions/delete-selected', [ExceptionController::class, 'deleteSelected'])->name('exceptions.delete-selected');
    Route::post('projects/{id}/exceptions/delete-fixed', [ExceptionController::class, 'deleteFixed'])->name('exceptions.delete-fixed');
    Route::resource('projects/{id}/exceptions', ExceptionController::class);
    Route::post('projects/{id}/exceptions/{exception}/fixed', [ExceptionController::class, 'fixed'])->name('exceptions.fixed');
    Route::post('projects/{id}/exceptions/{exception}/snooze', [ExceptionController::class, 'snooze'])->name('exceptions.snooze');
    Route::post('projects/{id}/exceptions/{exception}/unsnooze', [ExceptionController::class, 'unSnooze'])->name('exceptions.un-snooze');
    Route::post('projects/{id}/exceptions/{exception}/toggle-public', [ExceptionController::class, 'togglePublic'])->name('exceptions.toggle-public');
    Route::post('projects/{id}/exceptions/mark-as', [ExceptionController::class, 'markAs'])->name('exceptions.mark-as');
    Route::post('projects/{id}/exceptions/mark-all-fixed', [ExceptionController::class, 'markAllAsFixed'])->name('exceptions.mark-all-fixed');
    Route::post('projects/{id}/exceptions/mark-all-read', [ExceptionController::class, 'markAllAsRead'])->name('exceptions.mark-all-read');
    //Issues
    Route::get('issues', [IssuesController::class, 'index'])->name('issues.index');
    Route::get('issues/{id}', [IssuesController::class, 'show'])->name('issues.show');
    Route::patch('issues/{id}/status', [IssuesController::class, 'updateStatus'])->name('issues.update-status');
});
