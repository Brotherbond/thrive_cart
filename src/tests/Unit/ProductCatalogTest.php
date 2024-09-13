<?php
use App\Product;
use App\ProductCatalog;
use PHPUnit\Framework\TestCase;

class ProductCatalogTest extends TestCase
{
    private ProductCatalog $productCatalog;

    protected function setUp(): void
    {
        $this->productCatalog = new ProductCatalog(
            new Product('P01', 'Test Product 1', 50.00),
            new Product('P02', 'Test Product 2', 30.00)
        );
    }

    public function testGetPrice(): void
    {
        $this->assertEquals(50.00, $this->productCatalog->getPrice('P01'));
        $this->assertEquals(30.00, $this->productCatalog->getPrice('P02'));
    }

    public function testInvalidProductCodeThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->productCatalog->getPrice('INVALID');
    }
}
