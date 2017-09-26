<?php

namespace Domain\Event;

use Domain\ValueObject\RollNumber;

class ReceiptRefundIssued
{
    private $rollNumber;

    public function __construct(RollNumber $rollNumber)
    {
        $this->rollNumber = $rollNumber;
    }
}
