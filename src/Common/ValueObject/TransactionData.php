<?php

namespace App\Common\ValueObject;

class TransactionData
{
    public function __construct(
        private readonly Bin $bin,
        private readonly Amount $amount,
        private readonly Currency $currency,
    ) {
    }

    public function getBin(): Bin
    {
        return $this->bin;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}
