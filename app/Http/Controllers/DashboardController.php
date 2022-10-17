<?php

namespace App\Http\Controllers;

use App\Dictionary\Currency;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $balancesKeyByCurrency = Auth::user()->userBalances()
            ->whereIn('currency', Currency::getList())
            ->get()
            ->keyBy('currency')
        ;

        return view('dashboard', [
            'currencyList' => Currency::getList(),
            'balancesKeyByCurrency' => $balancesKeyByCurrency,
        ]);
    }
}
