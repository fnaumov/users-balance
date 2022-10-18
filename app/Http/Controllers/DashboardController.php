<?php

namespace App\Http\Controllers;

use App\Dictionary\Currency;
use App\Models\Transaction;
use Illuminate\Http\Request;
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

    public function refresh(Request $request)
    {
        $balancesKeyByCurrency = Auth::user()->userBalances()
            ->select('balance', 'currency')
            ->whereIn('currency', Currency::getList())
            ->get()
            ->keyBy('currency')
        ;

        $transactions = Transaction::getNewTransactions(
            Auth::user()->id,
            self::TRANSACTION_LIMIT,
            $request->get('last_transaction_id')
        );

        return response()->json([
            'balances' => $balancesKeyByCurrency,
            'transactions' => $transactions,
        ]);
    }
}
