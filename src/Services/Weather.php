<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class Weather
{
    private $client;
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    public function getweather():array
    {
        $response = $this->client->request(
            'GET',
            'https://api.open-meteo.com/v1/gfs?latitude=48.85&longitude=2.35&hourly=temperature_2m&forecast_days=1&timezone=Europe%2FBerlin'
        );
        return $response->toArray();
    }

    public function setWeather()
    {
        $temperatureIndex = 13;
        $data = $this->getWeather();

        $weather = $data['hourly']['temperature_2m'][13];

            if ($weather != null) {
                $temperature = $data['hourly']['temperature_2m'][$temperatureIndex];
                echo $temperature;

                $temperatureIndex = ($temperatureIndex + 1) % count($data['hourly']['temperature_2m']);
        } else {
            echo 'Erreur lors de la récupération des données météorologiques.';
        }
        return 'La météo à Paris ' . $weather;
    }
}