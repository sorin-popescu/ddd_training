<?php

namespace Application;

use Domain\Entity\Receipt;
use Domain\Repository\Receipts;
use Domain\ValueObject\IssueDate;
use Domain\ValueObject\Price;
use Domain\ValueObject\Product;
use Domain\ValueObject\Products;
use Domain\ValueObject\RollNumber;
use Domain\ValueObject\Sku;
use Query\Projector\ReceiptsIssuedProjector;

class Till
{
    private $receipts;
    private $projector;

    public function __construct(Receipts $receipts, ReceiptsIssuedProjector $projector)
    {
        $this->receipts = $receipts;
        $this->projector = $projector;
    }

    public function receiptStore(string $rollNumber, string $issueDate, array $products)
    {
        $catalog = Products::create();
        foreach ($products as $product) {
            $sku = Sku::fromIdentifier($product['sku']);
            $price = Price::fromAmount($product['price']);
            $productObj = Product::fromSkuAndPrice($sku, $price);
            $catalog->add($productObj);
        }

        $receipt = Receipt::issue(
            RollNumber::fromIdentifier($rollNumber),
            IssueDate::fromString($issueDate),
            $catalog
        );

        $this->receipts->store($receipt);
        $this->projector->applyReceiptIssued();
    }
}
