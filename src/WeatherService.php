<?php

namespace Phpweatherapp;

use GuzzleHttp\Client;

class WeatherService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function displayWeather(float $lat, float $lon): void
    {
        $response = $this->client->get('https://api.open-meteo.com/v1/forecast', [
            'query' => [
                'latitude' => $lat,
                'longitude' => $lon,
                'current' => 'temperature_2m,relative_humidity_2m,apparent_temperature,precipitation,cloud_cover,wind_speed_10m,wind_gusts_10m',
                'timezone' => 'auto',
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        $current = $data['current'] ?? [];
        $units = $data['current_units'] ?? [];

        if (!$current) {
            echo 'No current weather data available.';
            return;
        }

        echo "Weather for {$data['latitude']}, {$data['longitude']}\n";
        echo "Time: " . ($current['time'] ?? 'n/a') . "\n";
        echo "Temperature: " . ($current['temperature_2m'] ?? 'n/a') . ($units['temperature_2m'] ?? '') . "\n";
        echo "Feels like: " . ($current['apparent_temperature'] ?? 'n/a') . ($units['apparent_temperature'] ?? '') . "\n";
        echo "Humidity: " . ($current['relative_humidity_2m'] ?? 'n/a') . ($units['relative_humidity_2m'] ?? '') . "\n";
        echo "Precipitation: " . ($current['precipitation'] ?? 'n/a') . ($units['precipitation'] ?? '') . "\n";
        echo "Cloud cover: " . ($current['cloud_cover'] ?? 'n/a') . ($units['cloud_cover'] ?? '') . "\n";
        echo "Wind: " . ($current['wind_speed_10m'] ?? 'n/a') . ($units['wind_speed_10m'] ?? '');
        echo " (gusts " . ($current['wind_gusts_10m'] ?? 'n/a') . ($units['wind_gusts_10m'] ?? '') . ")\n";
    }
}