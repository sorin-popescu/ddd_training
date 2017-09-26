<?php

namespace Domain\Event;

use Domain\ValueObject\IssueDate;
use Domain\ValueObject\Products;
use Domain\ValueObject\RollNumber;

class ReceiptIssued
{
    private $rollNumber;

    private $issueDate;

    private $products;

    public function __construct(RollNumber $rollNumber, IssueDate $issueDate, Products $products)
    {
        $this->rollNumber = $rollNumber;
        $this->issueDate = $issueDate;
        $this->products = $products;
    }
}
