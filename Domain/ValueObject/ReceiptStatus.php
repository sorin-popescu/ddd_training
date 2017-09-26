<?php

namespace Domain\ValueObject;

class ReceiptStatus
{
    const REFUNDED = 'refunded';
    const ISSUED = 'issued';

    private $status;

    private function __construct($status)
    {
        $this->status = $status;
    }

    public static function refunded()
    {
        return new self(self::REFUNDED);
    }

    public static function issued()
    {
        return new self(self::ISSUED);
    }

    public function isRefunded()
    {
        return $this->status === self::REFUNDED;
    }
}
