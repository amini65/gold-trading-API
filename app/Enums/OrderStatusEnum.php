<?php

namespace App\Enums;

enum OrderStatusEnum : string
{
    case OPEN = "open";
    case COMPLETED = "completed";
    case CANCELLED = "canceled";
    case PARTIAL = "partial";

    public static function getValuesInArray(): array
    {
        $resultArray = [];

        foreach (self::cases() as $key => $value) {
            $resultArray[] = $value->value;
        }

        return $resultArray;
    }
}
