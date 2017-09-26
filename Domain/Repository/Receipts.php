<?php

namespace Domain\Repository;

use Domain\Entity\Receipt;
use Domain\ValueObject\RollNumber;

interface Receipts
{
    public function store(Receipt $receipt);
    public function load(RollNumber $rollNumber);
}
