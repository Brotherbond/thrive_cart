<?php

use App\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testProductAttributes(): void
    {
        $product = new Product('P01', 'Test Product', 25.50);

        $this->assertEquals('P01', $product->getCode());
        $this->assertEquals('Test Product', $product->getName());
        $this->assertEquals(25.50, $product->getPrice());
    }
}
