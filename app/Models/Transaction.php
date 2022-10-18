<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'currency',
        'direction',
        'description',
    ];

    protected $casts = [
        'created_at'  => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public static function getNewTransactions(int $userId, int $transactionLimit, ?int $lastTransactionId)
    {
        $whereExpressions[] = ['user_id', '=', $userId];

        $lastId = (int) $lastTransactionId;

        if ($lastId) {
            $whereExpressions[] = ['id', '>', $lastId];
        }

        return Transaction::select('id', 'amount', 'currency', 'description', 'created_at')
            ->where($whereExpressions)
            ->orderByDesc('created_at')
            ->limit($transactionLimit)
            ->get();
    }
}
