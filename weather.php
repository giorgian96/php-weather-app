<?php

use Phpweatherapp\WeatherService;

require_once __DIR__ . '/vendor/autoload.php';

$weatherService = new WeatherService();

$lat = $argv[1] ?? 45.79;
$lon = $argv[2] ?? 24.15;

$weatherService->displayWeather($lat, $lon);