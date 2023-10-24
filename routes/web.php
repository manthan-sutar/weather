<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/

Route::get('/', function () {
    return redirect()->route('current_weather');
});

Route::get('/weather/current', [WeatherController::class, 'currentWeather'])->name('current_weather');
Route::get('/weather/future-hours', [WeatherController::class, 'currentWeatherFutureHours'])->name('current_weather.future-hours');
Route::get('/weather/future-days', [WeatherController::class, 'currentWeatherFutureDays'])->name('current_weather.future-days');
