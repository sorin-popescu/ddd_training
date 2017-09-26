<?php
/**
 * Created by PhpStorm.
 * User: sorin.popescu
 * Date: 26/09/2017
 * Time: 15:11
 */

namespace Application;


use Command\IssueReceipt;
use Command\RefundReceipt;
use Domain\Entity\Receipt;
use Domain\Event\ReceiptIssued;
use Domain\Repository\Receipts;
use Domain\ValueObject\IssueDate;
use Domain\ValueObject\Price;
use Domain\ValueObject\Product;
use Domain\ValueObject\Products;
use Domain\ValueObject\RollNumber;
use Domain\ValueObject\Sku;
use Infrastructure\Repository\ReceiptEventStore;
use Query\Projector\ReceiptsIssuedProjector;

class ReceiptCommandHandler
{
    private $receipts;
    private $projector;

    public function __construct(Receipts $receipts, ReceiptsIssuedProjector $projector)
    {
        $this->receipts = $receipts;
        $this->projector = $projector;
    }

    public function handleReceiptIssue(IssueReceipt $command)
    {
        $catalog = Products::create();
        foreach ($command->getProducts() as $product) {
            $sku = Sku::fromIdentifier($product['sku']);
            $price = Price::fromAmount($product['price']);
            $productObj = Product::fromSkuAndPrice($sku, $price);
            $catalog->add($productObj);
        }

        $receipt = Receipt::issue(
            RollNumber::fromIdentifier($command->getRollNumber()),
            IssueDate::fromString($command->getIssueDate()),
            $catalog
        );

        $this->receipts->store($receipt);
        $this->projector->applyReceiptIssued();
    }

    public function handleCashReceiptRefund(RefundReceipt $command)
    {
        $rollNumber = RollNumber::fromIdentifier($command->getRollNumber());
        $refundDate = new \DateTimeImmutable($command->getRefundDate());
        /** @var Receipt $receipt */
        $receipt = $this->receipts->load($rollNumber);
        $receipt->cashRefund($refundDate);
        $this->receipts->store($receipt);
    }

    public function handleStoreReceiptRefund(RefundReceipt $command)
    {
        $rollNumber = RollNumber::fromIdentifier($command->getRollNumber());
        $refundDate = new \DateTimeImmutable($command->getRefundDate());
        /** @var Receipt $receipt */
        $receipt = $this->receipts->load($rollNumber);
        $receipt->storeCreditRefund($refundDate);
        $this->receipts->store($receipt);
    }
}
