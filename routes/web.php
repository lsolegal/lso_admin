<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AuthController;









// response testing
Route::get('pk-detailed-kundli', [FrontendController::class, 'pk_detailed_kundli']);
Route::get('pk-planet-detailed', [FrontendController::class, 'pk_planet_detailed']);
Route::get('pk-output', [FrontendController::class, 'pk_output']);

Route::get('va-planet-details', [FrontendController::class, 'va_planet_details']);

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
Route::get('/', [FrontendController::class, 'index']);
Route::post('get-kundli', [FrontendController::class, 'get_kundli']);
Route::get('full-details', [FrontendController::class, 'full_details']);
Route::get('test', [FrontendController::class, 'mangal_dosh']);

// different routes for different horoscoope
Route::get('birth-chart', [FrontendController::class, 'birth_chart']);
Route::get('match-horoscope', [FrontendController::class, 'match_horoscope']);
Route::get('life-prediction', [FrontendController::class, 'life-prediction']);
Route::get('gochar-fal', [FrontendController::class, 'gochar-fal']);
Route::get('lal-kitab', [FrontendController::class, 'lal-kitab']);
Route::get('mangal-dosh', [FrontendController::class, 'mangal_dosh']);
Route::get('gemstones', [FrontendController::class, 'gemstones']);
Route::get('my-day-today', [FrontendController::class, 'my-day-today']);
Route::get('sade-sati', [FrontendController::class, 'sade_sati']);
Route::get('kalsarp-dosh', [FrontendController::class, 'kalsarp-dosh']);




// login route
Route::get('login', [AuthController::class, 'login']);
Route::post('login', [AuthController::class, 'post_login']);

// signup route
Route::get('sign-up', [AuthController::class, 'signup']);
Route::post('sign-up', [AuthController::class, 'post_signup']);

// Route::get('/', function () {
//     return view('welcome');
// });


