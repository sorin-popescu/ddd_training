<?php

namespace Domain\ValueObject;

class IssueDate
{
    /** @var DateTimeImmutable */
    private $issueDate;

    private function __construct(string $date)
    {
        $this->issueDate = new \DateTimeImmutable($date);
    }

    public static function fromString(string $date)
    {
        return new self($date);
    }

    public function isOutsideCashRefund(\DateTimeImmutable $date)
    {
        $newDate = $date->sub(new \DateInterval('P30D'));

        return $this->issueDate->setTime(0, 0, 0) < $newDate->setTime(0, 0, 0);
    }

    public function isOutsideStoreCreditRefund(\DateTimeImmutable $date)
    {
        $newDate = $date->sub(new \DateInterval('P1Y'));
        return $this->issueDate->setTime(0, 0, 0) < $newDate->setTime(0, 0, 0);
    }
}
