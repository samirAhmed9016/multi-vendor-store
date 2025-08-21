<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Services\CurrencyConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CurrencyConverterController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'currency_code' => 'required|string|size:3',

        ]);

        $baseCurrency = config('app.currency', 'USD');
        $currencyCode = $request->input('currency_code');

        $cacheKey = 'currency_rate' . $currencyCode;

        $rate = Cache::get($cacheKey, []);

        if (! $rate) {
            $converter = new CurrencyConverter(config('services.currency_converter.api_key'));
            $rate = $converter->convert(1, $baseCurrency, $currencyCode);
            Cache::put($cacheKey, $rate, now()->addMinutes(60));
        }

        Session::put('currency_code', $currencyCode);


        return redirect()->back();
    }
}
