<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private const CURRENCY_LIST = ['usd', 'eur', 'rub'];

    public function index()
    {
        $balancesKeyByCurrency = Auth::user()->userBalances()
            ->whereIn('currency', self::CURRENCY_LIST)
            ->get()
            ->keyBy('currency')
        ;

        return view('dashboard', [
            'currencyList' => self::CURRENCY_LIST,
            'balancesKeyByCurrency' => $balancesKeyByCurrency,
        ]);
    }
}
