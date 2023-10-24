

@extends('layouts.app')

@section('title', 'Current Weather')

@section('content')
    <div class="">
       <form method="GET">
            <div class="uk-margin">
                <input class="uk-input" type="text" id="locationInput" name="location" value="<?php echo $_GET['location'] ?? '' ?>" placeholder="Location">
            </div>
            <button class="uk-button uk-button-primary">Get Weather</button>
       </form>
    </div>
    @if (isset($weatherData) && is_object($weatherData))
    <div class="uk-margin-top" id="weatherInfo">
        <div id="forecastData">
            <ul class="uk-list">
                <li><span>Weather Description</span> : {{$weatherData->weather[0]->description}}</li>
                <li><span>Current Temperature </span> : {{$weatherData->main->temp}}°C</li>
                <li><span>Feel Like</span> : {{$weatherData->main->feels_like}}°C</li>
                <li><span>Humidity</span> : {{$weatherData->main->humidity}}</li>
            </ul>
        </div>
    </div>

    @php
        $params = ['lat' => $weatherData->coord->lat, 'lon' => $weatherData->coord->lon, 'location' => $_GET['location']];
    @endphp

    <div class="uk-flex uk-margin-medium-top">
        <a href="{{route('current_weather', $params)}}" class="uk-margin-medium-right">Current Weather</a>
        <a href="{{ route('current_weather.future-hours', $params);}}" class="uk-margin-medium-right">Next 24 hours</a>
        <a href="{{ route('current_weather.future-days', $params);}}" class="uk-margin-medium-right">Next 7 days</a>
    </div>
    
    @else
        <h4>{{$weatherData}}</h4>
    @endif

@endsection