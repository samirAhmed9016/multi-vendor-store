<?php

namespace App\helpers;

use NumberFormatter;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;


class Currency
{
    // public static function format($amount, $currency = null)
    // {
    //     // Default to system locale or 'en_US'
    //     $locale = locale_get_default() ?: 'en_US';
    //     $currency = $currency ?: 'USD';
    //     // Check if intl extension is loaded
    //     if (class_exists('NumberFormatter')) {
    //         $formatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
    //         return $formatter->formatCurrency($amount, $currency);
    //     }
    //     // Fallback if intl is not available
    //     return number_format($amount, 2) . ' ' . $currency;
    // }



    public static function format($amount, $currency = null, $withSymbol = true)
    {
        // Step 1: Get user-selected currency (or default)
        $currency = $currency ?: Session::get('currency_code', config('app.currency', 'USD'));
        $baseCurrency = config('app.currency', 'USD');

        // Step 2: Convert amount if needed
        if ($currency !== $baseCurrency) {
            $rate = Cache::get('currency_rate' . $currency, 1);
            $amount = $amount * $rate;
        }

        // Step 3: Format the amount
        $locale = locale_get_default() ?: 'en_US';

        if (class_exists('NumberFormatter')) {
            $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
            $formatted = $formatter->formatCurrency($amount, $currency);

            // If user doesn't want the currency symbol
            if (!$withSymbol) {
                $formatted = preg_replace('/[^\d.,-]/', '', $formatted);
            }

            return $formatted;
        }

        // Fallback formatting
        return number_format($amount, 2) . ($withSymbol ? ' ' . $currency : '');
    }

    /**
     * Convert amount without formatting (returns number only)
     */
    public static function convert($amount, $currency = null)
    {
        $currency = $currency ?: Session::get('currency_code', config('app.currency', 'USD'));
        $baseCurrency = config('app.currency', 'USD');

        if ($currency !== $baseCurrency) {
            $rate = Cache::get('currency_rate' . $currency, 1);
            return $amount * $rate;
        }

        return $amount;
    }
}
