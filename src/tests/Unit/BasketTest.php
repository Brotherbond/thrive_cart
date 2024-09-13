<?php
use App\Basket;
use App\Product;
use App\ProductCatalog;
use App\Services\Delivery\DeliveryCharge;
use App\Services\Offers\BuyOneGetOneHalfOffOffer;
use PHPUnit\Framework\TestCase;

class BasketTest extends TestCase
{
    private Basket $basket;

    protected function setUp(): void
    {
        $productCatalog = new ProductCatalog(
            new Product('P01', 'Product 1', 50.00),
            new Product('R01', 'Red Widget', 100.00)
        );

        $this->basket = new Basket(
            $productCatalog,
            [new DeliveryCharge()],
            [new BuyOneGetOneHalfOffOffer($productCatalog)]
        );
    }

    public function testAddAndRemoveProducts(): void
    {
        $this->basket->add('P01');
        $this->assertEquals(['P01' => 1], $this->basket->getItems());

        $this->basket->add('P01');
        $this->assertEquals(['P01' => 2], $this->basket->getItems());

        $this->basket->remove('P01');
        $this->assertEquals(['P01' => 1], $this->basket->getItems());

        $this->basket->remove('P01', true);
        $this->assertEmpty($this->basket->getItems());
    }

    public function testGetTotal(): void
    {
        $this->basket->add('P01');
        $this->basket->add('R01');
        $this->basket->add('R01'); // Buy One Get One Half Off applies here

        $this->assertEquals(200.00, $this->basket->getTotal());
    }
}
