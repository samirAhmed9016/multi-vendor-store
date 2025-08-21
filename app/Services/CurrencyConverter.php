<?php

namespace App\Services;



use Illuminate\Support\Facades\Http;

class CurrencyConverter
{
    private $apiKey;
    protected $currenciesUrl = 'https://api.freecurrencyapi.com/v1/currencies';
    protected $latestUrl = 'https://api.freecurrencyapi.com/v1/latest';

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    // Convert an amount from one currency to another
    public function convert(float $amount, string $from, string $to): float
    {
        $response = Http::get($this->latestUrl, [
            'apikey' => $this->apiKey,
            'base_currency' => $from,
            'currencies' => $to
        ]);

        $rate = $response->json("data.$to");

        return round($amount * $rate, 2);
    }

    // Get the list of supported currencies
    public function getCurrencies(array $codes = []): array
    {
        $params = ['apikey' => $this->apiKey];

        if (!empty($codes)) {
            $params['currencies'] = implode(',', $codes);
        }

        $response = Http::get($this->currenciesUrl, $params);

        return $response->json('data');
    }
}
