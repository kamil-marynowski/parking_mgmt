<?php

namespace App\Services;

use GuzzleHttp\Client;

class CurrenciesApiRatesService
{
    public function getCurrencyRatesFromEUR(): array
    {
        $uri = 'http://api.exchangeratesapi.io/v1/latest?access_key=7e746392773d633035534f34fefddf0d';

        $client = new Client();
        $response = $client->get($uri);
        $responseBody = json_decode($response->getBody()->getContents(), true);

        return $responseBody['rates'];
    }
}