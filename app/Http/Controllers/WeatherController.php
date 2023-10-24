<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\OpenWeatherApiRepository;

class WeatherController extends Controller
{
    protected $apiRepository;

    public function __construct(OpenWeatherApiRepository $apiRepository)
    {
        $this->apiRepository = $apiRepository;
    }

    public function currentWeather(Request $request)
    {
        $location = $request->input('location');
        $weatherData = $this->apiRepository->getWeatherByLocation($location);
        return view('current-weather', compact('weatherData'));
    }

    public function currentWeatherFutureHours(Request $request)
    {
        $payload = $request->all();
        $weatherData = $this->apiRepository->getFutureWeather( $payload['lat'],  $payload['lon'], "hourly");
        // return $weatherData;
        return view('future-hourly-weather', compact('weatherData'));
    }


    public function currentWeatherFutureDays(Request $request)
    {
        $payload = $request->all();
        $weatherData = $this->apiRepository->getFutureWeather( $payload['lat'],  $payload['lon'], "daily");
        return view('future-daily-weather', compact('weatherData'));
    }
}
