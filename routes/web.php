<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Middleware\CheckUserIsStaff;
use App\Models\Feedback;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', \App\Http\Controllers\IndexController::class)->name('index');

// Feedbacks

Route::resource('feedbacks', FeedbackController::class)
    ->except(['index', 'destroy']);


// Route for staff to see feedbacks and delete
Route::middleware(CheckUserIsStaff::class)->group(function () {
    Route::resource('feedbacks', FeedbackController::class)
        ->only(['index', 'destroy', 'restore']);

    Route::post('feedbacks/{feedback}/restore', [FeedbackController::class, 'restore'])->name('feedbacks.restore');

});
