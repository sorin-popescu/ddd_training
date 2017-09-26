<?php

namespace Application;

use Domain\Entity\Receipt;
use Domain\Repository\Receipts;
use Domain\ValueObject\RollNumber;

class Refund
{
    private $receipts;

    public function __construct(Receipts $receipts)
    {
        $this->receipts = $receipts;
    }

    public function cashRefund(string $rollNumber, \DateTimeImmutable $refundDate)
    {
        /** @var Receipt $receipt */
        $receipt = $this->receipts->load(RollNumber::fromIdentifier($rollNumber));
        $receipt->cashRefund($refundDate);
        $this->receipts->store($receipt);
    }

    public function storeCreditRefund(RollNumber $rollNumber, \DateTimeImmutable $refundDate)
    {
        /** @var Receipt $receipt */
        $receipt = $this->receipts->load($rollNumber);
        $receipt->storeCreditRefund($refundDate);
        $this->receipts->store($receipt);
    }
}
