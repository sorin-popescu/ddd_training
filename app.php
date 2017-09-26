<?php

require_once(__DIR__ . "/Domain/ValueObject/RollNumber.php");
require_once(__DIR__ . "/Domain/ValueObject/Price.php");
require_once(__DIR__ . "/Domain/ValueObject/Sku.php");
require_once(__DIR__ . "/Domain/ValueObject/Product.php");
require_once(__DIR__ . "/Domain/ValueObject/Products.php");
require_once(__DIR__ . "/Domain/Entity/Receipt.php");
require_once(__DIR__ . "/Infrastructure/FileReceipts.php");
require_once(__DIR__ . "/Infrastructure/ReceiptEventStore.php");
require_once(__DIR__ . "/Domain/ValueObject/IssueDate.php");
require_once(__DIR__ . "/Domain/ValueObject/ReceiptStatus.php");
require_once(__DIR__ . "/Application/ReceiptCommandHandler.php");
require_once(__DIR__ . "/Query/Repository/ReceiptRefundIssuedCount.php");
require_once(__DIR__ . "/Query/Projector/ReceiptsIssuedProjector.php");
require_once(__DIR__ . "/Command/IssueReceipt.php");




$receipts = new \Infrastructure\Repository\ReceiptEventStore();
$countRepository = new \Query\Repository\ReceiptRefundIssuedCount();
$receiptCommand = new \Application\ReceiptCommandHandler(
    $receipts,
    new \Query\Projector\ReceiptsIssuedProjector($countRepository)
);

$receiptCommand->handleReceiptIssue(new \Command\IssueReceipt(
    '123',
    '2017-09-24',
    [
        [
            'sku' => 'ABC123',
            'price' => 10,
        ],
        [
            'sku' => 'ABC124',
            'price' => 12.5,
        ]
    ]
));


//$till = new \Application\Till($receipts, new \Query\Projector\ReceiptsIssuedProjector($countRepository));
//$refund = new \Application\Refund($receipts);

//$till->receiptStore(

//);
//
//$refund->cashRefund('123', new DateTimeImmutable());
