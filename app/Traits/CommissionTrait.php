<?php

namespace App\Traits;

trait CommissionTrait
{

    private const TIER_1_RATE = 0.02;
    private const TIER_2_RATE = 0.015;
    private const TIER_3_RATE = 0.01;

    private const MIN_COMMISSION = 500000;
    private const MAX_COMMISSION = 50000000;

    public function calculateCommission($amount, $price, $rate=null)
    {
        if($rate==null)
             $rate = $this->getRate($amount);



        $commission = $price * $rate;

        $commission = max($commission, self::MIN_COMMISSION);
        $commission = min($commission, self::MAX_COMMISSION);

        $goldCommission= $amount * $rate;
        $gold= $goldCommission / $rate;

        return [
            'priceCommission' => $commission,
            'goldCommission' => $goldCommission,
            'gold' => round($gold +$goldCommission),
            'rateCommission' => $rate
        ];
    }

    public function getRate(float $amount): float
    {
        if ($amount <= 1) {
            return self::TIER_1_RATE;
        } elseif ($amount <= 10) {
            return self::TIER_2_RATE;
        } else {
            return self::TIER_3_RATE;
        }
    }
}
