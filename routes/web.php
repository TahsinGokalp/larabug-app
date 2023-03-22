<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Exceptions\ExceptionActionController;
use App\Http\Controllers\Exceptions\ExceptionController;
use App\Http\Controllers\Exceptions\ExceptionDeleteController;
use App\Http\Controllers\Issues\IssuesController;
use App\Http\Controllers\Projects\ProjectController;
use App\Http\Controllers\Projects\ProjectInstallationController;
use App\Http\Controllers\Projects\ProjectRefreshTokenController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Route;

Route::permanentRedirect('/', 'login');

Route::get('exception/{exception:publish_hash}', [DashboardController::class, 'exception'])->name('public.exception');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    //Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Projects
    Route::resource('projects', ProjectController::class);
    Route::prefix('projects/{id}')->group(static function () {
        Route::get('installation', [ProjectInstallationController::class, 'index'])->name('projects.installation');
        Route::post('refresh-token', [ProjectRefreshTokenController::class, 'index'])->name('projects.refresh-token');
        //Exceptions
        Route::resource('exceptions', ExceptionController::class, [
            'only' => ['index', 'show', 'destroy'],
        ]);
        Route::prefix('exceptions')->group(static function () {
            //Delete Exception
            Route::delete('delete-all', [ExceptionDeleteController::class, 'deleteAll'])->name('exceptions.delete-all');
            Route::post('delete-selected', [ExceptionDeleteController::class, 'deleteSelected'])->name('exceptions.delete-selected');
            Route::post('delete-fixed', [ExceptionDeleteController::class, 'deleteFixed'])->name('exceptions.delete-fixed');
            //Exception Actions
            Route::post('{exception}/fixed', [ExceptionActionController::class, 'fixed'])->name('exceptions.fixed');
            Route::post('{exception}/snooze', [ExceptionActionController::class, 'snooze'])->name('exceptions.snooze');
            Route::post('{exception}/unsnooze', [ExceptionActionController::class, 'unSnooze'])->name('exceptions.un-snooze');
            Route::post('{exception}/toggle-public', [ExceptionActionController::class, 'togglePublic'])->name('exceptions.toggle-public');
            Route::post('mark-as', [ExceptionActionController::class, 'markAs'])->name('exceptions.mark-as');
            Route::post('mark-all-fixed', [ExceptionActionController::class, 'markAllAsFixed'])->name('exceptions.mark-all-fixed');
            Route::post('mark-all-read', [ExceptionActionController::class, 'markAllAsRead'])->name('exceptions.mark-all-read');
        });
    });

    //Issues
    Route::prefix('issues')->group(static function () {
        Route::get('/', [IssuesController::class, 'index'])->name('issues.index');
        Route::get('{id}', [IssuesController::class, 'show'])->name('issues.show');
        Route::patch('{id}/status', [IssuesController::class, 'updateStatus'])->name('issues.update-status');
    });

    //Users
    Route::resource('users', UserController::class);
});
