<?php
namespace App;

class ProductCatalog
{
    /** @var array<string, Product> */
    private array $products = [];

    public function __construct(Product ...$products)
    {
        foreach ($products as $product) {
            $this->products[$product->getCode()] = $product;
        }
    }

    public function getPrice(string $productCode): float
    {
        if (!array_key_exists($productCode, $this->products)) {
            throw new \InvalidArgumentException("Invalid product code: $productCode");
        }

        return $this->products[$productCode]->getPrice();
    }

    public function getProductName(string $productCode): string
    {
        if (!array_key_exists($productCode, $this->products)) {
            throw new \InvalidArgumentException("Invalid product code: $productCode");
        }

        return $this->products[$productCode]->getName();
    }
}
