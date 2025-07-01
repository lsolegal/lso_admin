<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StaffContrller;









// response testing
Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // staff routes
    Route::resource('staff', StaffContrller::class);
});

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
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'post_login']);
Route::post('logout', [AuthController::class, 'logout']);

// login route
// Route::get('login', [AuthController::class, 'login']);
// Route::post('login', [AuthController::class, 'post_login']);

// signup route
// Route::get('sign-up', [AuthController::class, 'signup']);
// Route::post('sign-up', [AuthController::class, 'post_signup']);

// Route::get('/', function () {
//     return view('welcome');
// });


