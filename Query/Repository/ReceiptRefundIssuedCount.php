<?php

namespace Query\Repository;

class ReceiptRefundIssuedCount
{
    const REFUNDED_RECEIPT = '/tmp/refunded';

    private $count = 1;

    public function increment()
    {
        if (file_exists(static::REFUNDED_RECEIPT)) {
            $this->count = file_get_contents(static::REFUNDED_RECEIPT);
            $this->count ++;
        }

        file_put_contents(static::REFUNDED_RECEIPT, $this->count, LOCK_EX);
    }
}
