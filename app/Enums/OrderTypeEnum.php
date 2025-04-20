<?php

namespace App\Enums;

enum OrderTypeEnum :string
{
    case  BUY = "buy";
    case SELL = "sell";

    public static function getValuesInArray(): array
    {
        $resultArray = [];

        foreach (self::cases() as $key => $value) {
            $resultArray[] = $value->value;
        }

        return $resultArray;
    }
}
