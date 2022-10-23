<?php

use Symfony\Contracts\HttpClient\HttpClientInterface;

class NbpService
{
    public function __construct(
        private string $baseUrl,
        private HttpClientInterface $client
    ){
    }

    public function getCurrencies(): array
    {
    }
}