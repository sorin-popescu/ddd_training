<?php

namespace Infrastructure\Repository;

require_once( __DIR__ . "/../Domain/Repository/Receipts.php");

use Domain\Entity\Receipt;
use Domain\Repository\Receipts;
use Domain\ValueObject\RollNumber;

class FileReceipts implements Receipts
{
    const FILE_NAME = '/tmp/receipts';

    public function load(RollNumber $rollNumber)
    {
        return unserialize(file_get_contents(static::FILE_NAME));
    }

    public function store(Receipt $receipt)
    {
        file_put_contents(static::FILE_NAME, serialize($receipt), LOCK_EX);
    }
}
