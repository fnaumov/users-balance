<?php

namespace App\Dictionary;

class Currency
{
    public const USD = 'usd';
    public const EUR = 'eur';
    public const RUB = 'rub';

    /**
     * @return string[]
     */
    public static function getList(): array
    {
        return [
            self::USD,
            self::EUR,
            self::RUB,
        ];
    }
}
