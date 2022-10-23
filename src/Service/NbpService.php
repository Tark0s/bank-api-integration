<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class NbpService
{
    public function __construct(
        private string $baseUrl,
        private HttpClientInterface $client
    ){
    }

    public function getCurrencies(): ResponseInterface
    {
        $this->client->withOptions(
            [
                'base_uri' => $this->baseUrl
            ]
        );

        $response = $this->client->request(
            'GET',
            'http://api.nbp.pl/api/exchangerates/tables/A',
            [
                'headers' => [
                    'Accept' => 'application/json'
                ]
            ]
        );

        return $response;
    }
}