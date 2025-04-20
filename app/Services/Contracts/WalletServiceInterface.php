<?php

namespace App\Services\Contracts;

use App\Models\Order;

interface WalletServiceInterface
{
    public function depositWallet(Order $order);
    public function addWallet(Order $order,Order $matchingOrder,$diffRemaining);
    public function addWalletSeller(Order $order,$diffRemaining);
    public function addWalletBuyer(Order $order,$diffRemaining);

    public function releaseWallet(Order $order);
    public function releaseBuyer(Order $order,$wallet);
    public function releaseSeller(Order $order,$wallet);


}
