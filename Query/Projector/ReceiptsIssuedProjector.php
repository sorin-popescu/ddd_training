<?php

namespace Query\Projector;

use Query\Repository\ReceiptRefundIssuedCount;

class ReceiptsIssuedProjector
{
    private $repository;

    public function __construct(ReceiptRefundIssuedCount $repository)
    {
        $this->repository = $repository;
    }

    public function applyReceiptIssued()
    {
        $this->repository->increment();
    }
}
