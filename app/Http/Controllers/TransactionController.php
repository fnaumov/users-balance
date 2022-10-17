<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Auth::user()->transactions()
            ->orderBy('created_at')
            ->paginate(20)
        ;

        return view('transactions', [
            'transactions' => $transactions,
        ]);
    }
}
