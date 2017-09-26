<?php

namespace Domain\Entity;

require_once (__DIR__ . '/../Event/ReceiptIssued.php');

use Domain\Event\ReceiptIssued;
use Domain\Event\ReceiptRefundIssued;
use Domain\ValueObject\IssueDate;
use Domain\ValueObject\Products;
use Domain\ValueObject\ReceiptStatus;
use Domain\ValueObject\RollNumber;

class Receipt
{
    /** @var RollNumber */
    private $rollNumber;

    /** @var IssueDate */
    private $issueDate;

    /** @var Products */
    private $products;

    private $status;

    private $events = [];

    private function __construct(RollNumber $rollNumber, IssueDate $issueDate, Products $products)
    {
        $this->products = $products;
        $this->issueDate = $issueDate;
        $this->rollNumber = $rollNumber;
        $this->status = ReceiptStatus::issued();
    }

    public static function issue(RollNumber $rollNumber, IssueDate $date, Products $products)
    {

        $receipt =  new self($rollNumber, $date, $products);
        $receipt->raise(new ReceiptIssued($rollNumber, $date, $products));

        return $receipt;
    }

    public function cashRefund(\DateTimeImmutable $date)
    {
        if ($this->status->isRefunded()) {
            throw new \RuntimeException();
        }
        if ($this->issueDate->isOutsideCashRefund($date)) {
            throw new \RuntimeException();
        }
        $this->raise(new ReceiptRefundIssued($this->rollNumber));

        $this->status = ReceiptStatus::refunded();
    }

    public function storeCreditRefund(\DateTimeImmutable $date)
    {
        if ($this->status->isRefunded()) {
            throw new \RuntimeException();
        }
        if ($this->issueDate->isOutsideStoreCreditRefund($date)) {
            throw new \RuntimeException();
        }
        $this->raise(new ReceiptRefundIssued($this->rollNumber));

        $this->status = ReceiptStatus::refunded();
    }

    public function raise($event)
    {
        $this->events[] = $event;
    }

    public function newEvents()
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}
