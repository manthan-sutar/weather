

@extends('layouts.app')

@section('title', 'Current Weather')

@section('content')
    <div class="">
       <form action="{{ route('current_weather') }}" method="GET">
            <div class="uk-margin">
                <input class="uk-input" type="text" id="locationInput" name="location" value="<?php echo $_GET['location'] ?? '' ?>" placeholder="Location">
            </div>
            <button class="uk-button uk-button-primary">Get Weather</button>
       </form>
    </div>
    @if (isset($weatherData) && is_object($weatherData))
    <div class="uk-margin-top" id="weatherInfo">


        <table class="uk-table uk-table-small uk-table-divider">
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Weather</th>
                    <th>Temp</th>
                </tr>
            </thead>
            <tbody>


                @for ($i = 0; $i < 7; $i++)
                    @php

                        $data = $weatherData->daily[$i];
                        $hour = $formattedTime = date('D, M j', $data->dt);   
                        $weather = $data->weather[0]->description;   
                        $temp = intval($data->temp->min)."/". intval($data->temp->max);
                    @endphp

                        <tr>
                            <td>{{$hour}}</td>
                            <td>{{$weather}}</td>
                            <td>{{$temp}}°C</td>
                        </tr>
                @endfor
            </tbody>
        </table>
    </div>

    @php
        $params = ['lat' => $_GET['lat'], 'lon' => $_GET['lon'], 'location' => $_GET['location']];
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