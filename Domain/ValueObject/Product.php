<?php

namespace Domain\ValueObject;

class Product
{
    /** @var Sku */
    private $sku;

    /** @var Price */
    private $price;

    private function __construct(Sku $sku, Price $price)
    {
        $this->sku = $sku;
        $this->price = $price;
    }

    public static function fromSkuAndPrice(Sku $sku, Price $price)
    {
        return new self($sku, $price);
    }
}
