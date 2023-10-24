<?php

namespace App\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class OpenWeatherApiRepository
{
    protected $client;
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('OPEN_WEATHER_API_KEY');
        $this->baseUrl = "http://api.openweathermap.org/data/2.5/";
    }


    protected function handleApiResponse($data)
    {
        if (property_exists($data, 'cod') && $data->cod === '404') {
            return 'City not found.';
        } elseif (property_exists($data, 'cod') && $data->cod !== 200) {
            return $data->message ?? 'An error occurred while fetching weather data.';
        }
        return null;
    }



    public function getWeatherByLocation($location)
    {
        if (!$location) {
            return 'Location is required.';
        }
        try {
            $response = $this->client->get($this->baseUrl . "weather?q=$location&appid=$this->apiKey");
            $data = json_decode($response->getBody());
           $this->handleApiResponse($data);
            return $data;
        } catch (GuzzleException $e) {
            if ($e->getResponse() && $e->getResponse()->getStatusCode() === 404) {
              return 'City not found.';
          }
            $errorMessage = 'Network error';
        } catch (\Exception $e) {
            return 'Something went wrong. Please try again';
        }
    }

    public function getFutureWeather($lat, $lon, $type)
    {
      $exclude = ["current",
      "minutely",
      "hourly",
      "daily"];
      // Use array_filter with a custom callback to remove the string
      $filteredExcludes = array_filter($exclude, function ($item) use ($type) {
          return $item !== $type;
      });

      $commaSeparatedfilteredExcludes = implode(',', $filteredExcludes);

        try {
            $response = $this->client->get($this->baseUrl . "onecall?lat=$lat&lon=$lon&exclude=$commaSeparatedfilteredExcludes&units=metric&appid=$this->apiKey");
            $data = json_decode($response->getBody());
           $this->handleApiResponse($data);
            return $data;
        } catch (GuzzleException $e) {
            $errorMessage = 'Network error';
        } catch (\Exception $e) {
            return 'Something went wrong. Please try again';
        }
    }
    
    
}
