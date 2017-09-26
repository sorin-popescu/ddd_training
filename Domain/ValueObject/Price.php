<?php

namespace Domain\ValueObject;

class Price
{
    /** @var float */
    private $amount;

    private function __construct(float $amount)
    {
        $this->amount = $amount;
    }

    public static function fromAmount(float $amount)
    {
        if ($amount < 0) {
            throw new \InvalidArgumentException('Amount cannot be negative');
        }

        return new self($amount);
    }
}
