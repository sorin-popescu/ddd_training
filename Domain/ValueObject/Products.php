<?php

namespace Domain\ValueObject;

class Products
{
    /** @var array */
    private $products;

    private function __construct(array $products = [])
    {
        $this->products = $products;
    }

    public static function create()
    {
        return new self();
    }

    public function add(Product $product)
    {
        $products = array_merge([$product], $this->products);
        return new self($products);
    }
}
