<?php

namespace App\Dictionary;

class TransactionDirection
{
    public const IN = 'in';
    public const OUT = 'out';

    /**
     * @return string[]
     */
    public static function getList(): array
    {
        return [
            self::IN,
            self::OUT,
        ];
    }
}
