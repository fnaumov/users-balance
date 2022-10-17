<?php

namespace App\Http\Controllers;

use App\Dictionary\Currency;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private const TRANSACTION_LIMIT = 5;

    public function index()
    {
        $balancesKeyByCurrency = Auth::user()->userBalances()
            ->whereIn('currency', Currency::getList())
            ->get()
            ->keyBy('currency')
        ;

        $transactions = Transaction::where(['user_id' => Auth::user()->id])
            ->orderByDesc('created_at')
            ->limit(self::TRANSACTION_LIMIT)
            ->get()
        ;

        return view('dashboard', [
            'currencyList' => Currency::getList(),
            'balancesKeyByCurrency' => $balancesKeyByCurrency,
            'transactions' => $transactions,
        ]);
    }
}
