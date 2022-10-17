<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    private const PAGE_LIMIT = 10;

    public function index(Request $request)
    {
        $whereExpressions[] = ['user_id', '=', Auth::user()->id];

        if ($descriptionSearch = $request->get('description_search')) {
            $whereExpressions[] = ['description', 'like', '%' . $descriptionSearch . '%'];
        }

        $transactions = Transaction::where($whereExpressions)
            ->orderByDesc('created_at')
            ->paginate(self::PAGE_LIMIT)
        ;

        return view('transactions', [
            'transactions' => $transactions,
        ]);
    }
}
