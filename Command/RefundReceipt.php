<?php

namespace Command;

class RefundReceipt
{
    private $rollNumber;

    private $refundDate;

    /**
     * @return string
     */
    public function getRefundDate()
    {
        return $this->refundDate;
    }

    /**
     * @return string
     */
    public function getRollNumber()
    {
        return $this->rollNumber;
    }

    /**
     * RefundReceipt constructor.
     * @param string $rollNumber
     * @param string $refundDate
     */
    public function __construct(string $rollNumber, string $refundDate)
    {
        $this->rollNumber = $rollNumber;
        $this->refundDate = $refundDate;
    }

}
