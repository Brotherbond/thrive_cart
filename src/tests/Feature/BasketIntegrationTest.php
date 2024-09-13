<?php
use App\Basket;
use App\Product;
use App\ProductCatalog;
use App\Services\Delivery\DeliveryCharge;
use App\Services\Offers\BuyOneGetOneHalfOffOffer;
use PHPUnit\Framework\TestCase;

class BasketIntegrationTest extends TestCase
{
    private Basket $basket;
    private ProductCatalog $productCatalog;

    protected function setUp(): void
    {
        $this->productCatalog = new ProductCatalog(
            new Product('R01', 'Red Widget', 32.95),
            new Product('G01', 'Green Widget', 24.95),
            new Product('B01', 'Blue Widget', 7.95),
        );

        $offers = [];
        $deliveryChargeRules = [new DeliveryCharge()];
        $IsSpecialOfferActive = !!getenv('IS_SPECIAL_OFFER_ACTIVE');
        if ($IsSpecialOfferActive) {
            $buyOneGetOneHalfOffOffer = new BuyOneGetOneHalfOffOffer($this->productCatalog);
            $offers[] = $buyOneGetOneHalfOffOffer;
        }

        $this->basket = new Basket($this->productCatalog, $deliveryChargeRules, $offers);
    }

    public function testAddProductToBasket(): void
    {
        $this->basket->add('R01');
        $items = $this->basket->getItems();
        $this->assertArrayHasKey('R01', $items);
        $this->assertEquals(1, $items['R01']);
    }

    public function testCalculateSubTotal(): void
    {
        $this->basket->add('R01');
        $this->assertEquals(32.95, $this->basket->getSubTotal());
    }

    public function testCalculateTotalWithOffers(): void
    {
        $this->basket->add('R01');
        $this->basket->add('R01');
        $this->assertEquals(49.42, $this->basket->getSubTotal() - $this->basket->getOffers());
    }

    public function testCalculateTotalWithDeliveryCharge(): void
    {
        $this->basket->add('R01');
        $this->assertEquals(37.9, $this->basket->getTotal());
    }

    public function BasketIntegrationFlow(): void
    {
        $this->basket->add('G01');
        $this->basket->add('B01');
        $this->basket->add('R01');
        $subtotal = $this->basket->getSubTotal();
        $offers = $this->basket->getOffers();
        $delivery = $this->basket->getDeliveryCost();
        $total = $this->basket->getTotal();

        $this->assertEquals(65.85, $subtotal);
        $this->assertEquals(0.00, $offers);
        $this->assertEquals(2.95, $delivery);
        $this->assertEquals(68.80, $total);
    }

    public function testBasketExample1(): void
    {
        $this->basket->add('B01');
        $this->basket->add('G01');
        $total = $this->basket->getTotal();

        $this->assertEquals(37.85, $total);
    }

    public function testBasketExample2(): void
    {
        $this->basket->add('R01');
        $this->basket->add('R01');
        $total = $this->basket->getTotal();

        $this->assertEquals(54.37, $total);
    }

    public function testBasketExample3(): void
    {
        $this->basket->add('R01');
        $this->basket->add('G01');
        $total = $this->basket->getTotal();

        $this->assertEquals(60.85, $total);
    }
    
    public function testBasketExample4(): void
    {
        $this->basket->add('B01');
        $this->basket->add('B01');
        $this->basket->add('R01');
        $this->basket->add('R01');
        $this->basket->add('R01');
        $total = $this->basket->getTotal();

        $this->assertEquals(98.27, $total);
    }
}
