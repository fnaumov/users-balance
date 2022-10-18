<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    private const PAGE_LIMIT = 10;
    private const SORT_DIRECTION_ASC = 'asc';
    private const SORT_DIRECTION_DESC = 'desc';

    public function index(Request $request)
    {
        $whereExpressions[] = ['user_id', '=', Auth::user()->id];

        if ($descriptionSearch = $request->get('description_search')) {
            $whereExpressions[] = ['description', 'like', '%' . $descriptionSearch . '%'];
        }

        $transactions = Transaction::where($whereExpressions);

        $sortField = $request->get('sort_field');
        $sortDirection = $request->get('sort_direction');

        if ($sortField === 'created_at' || empty($sortField)) {
            $sortDirection === self::SORT_DIRECTION_ASC
                ? $transactions->orderBy('created_at')
                : $transactions->orderByDesc('created_at')
            ;
        }

        return view('transactions', [
            'transactions' => $transactions->paginate(self::PAGE_LIMIT),
        ]);
    }
}
