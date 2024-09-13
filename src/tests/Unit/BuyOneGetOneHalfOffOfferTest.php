<?php
use App\Product;
use App\ProductCatalog;
use App\Services\Offers\BuyOneGetOneHalfOffOffer;
use PHPUnit\Framework\TestCase;

class BuyOneGetOneHalfOffOfferTest extends TestCase
{
    private BuyOneGetOneHalfOffOffer $offer;

    protected function setUp(): void
    {
        $productCatalog = new ProductCatalog(
            new Product('R01', 'Red Widget', 100.00)
        );
        $this->offer = new BuyOneGetOneHalfOffOffer($productCatalog);
    }

    public function testApplyOffer(): void
    {
        $basket = ['R01' => 3]; // 3 Red Widgets
        $discount = $this->offer->apply($basket);

        $this->assertEquals(50.00, $discount); // 1 widget at half price
    }

    public function testNoDiscountForSingleItem(): void
    {
        $basket = ['R01' => 1];
        $discount = $this->offer->apply($basket);

        $this->assertEquals(0.00, $discount);
    }
}
