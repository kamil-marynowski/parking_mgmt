<?php

declare(strict_types=1);

namespace App\Services;

class CurrencyService
{
    private CurrenciesApiRatesService $currenciesApiRatesService;

    private array $rates;

    public function __construct()
    {
        $this->currenciesApiRatesService = new CurrenciesApiRatesService();
        $this->rates = $this->currenciesApiRatesService->getCurrencyRatesFromEUR();
    }

    public function convertUsdTo($currency, $value): float|int
    {
        //convert usd to eur (because it was only free option in chosen API)
        $value = $this->convertFromUsdToEur($value);

        //convert to chosen currency by its rate FROM EUR to currency
        return $value * $this->rates[$currency];
    }

    private function convertFromUsdToEur($value): float|int
    {
        $usdToEurRate = 1 / $this->rates['USD'];

        return $value * $usdToEurRate;
    }
}