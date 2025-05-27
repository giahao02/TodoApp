<?php

use App\Http\Controllers\Api\TodoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/list', function () {
    return view('list');
});


// -- Login Register
// Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
// Route::post('/register', [AuthController::class, 'register'])->name('register');

// Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
// Route::post('/login', [AuthController::class, 'login'])->name('login');

// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::get('/dashboard', function () {
//     return view('dashboard-test');
// })->middleware('auth')->name('dashboard');




// -- Login Register with Breeze
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
