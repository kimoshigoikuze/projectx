<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function() {

    Route::get('/emails', function () {
        return Inertia::render('Emails');
    });

    Route::get('/api/getEmails', function () {
        return \App\Models\Email::all()->toJson();
    });

    Route::get('/api/getAttachments/{mail_id}', function ($mail_id) {
        return \App\Models\Attachment::where('mail_id', $mail_id)->get()->toJson();
    });
});

require __DIR__.'/auth.php';
