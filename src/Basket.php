<?php
namespace App;

use App\Services\Delivery\Delivery;
use App\Services\Offers\Offer;

class Basket
{
    /** @var array<string, int> */
    private array $items = [];
    private ProductCatalog $productCatalog;
    /** @var Delivery[] */
    private array $deliveryChargeRules;

    /** @var Offer[] */
    private array $offers;

     /**
     * @param Delivery[] $deliveryChargeRules
     * @param Offer[] $offers
     */
    public function __construct(ProductCatalog $productCatalog, array $deliveryChargeRules = [], array $offers = [])
    {
        $this->productCatalog = $productCatalog;
        $this->deliveryChargeRules = $deliveryChargeRules;
        $this->offers = $offers;
    }
    public function add(string $productCode): void
    {
        if (!$this->productCatalog->getProductName($productCode)) {
            throw new \InvalidArgumentException("Invalid product code: $productCode");
        }
        if (!isset($this->items[$productCode])) {
            $this->items[$productCode] = 0;
        }
        $this->items[$productCode]++;
    }

    public function getDeliveryCost(): float
    {
        $charge = 0.00;
        foreach ($this->deliveryChargeRules as $rule) {
            $charge += $rule->calculate($this->getSubTotal() - $this->getOffers());
        }
        return $charge;
    }

    public function getOffers(): float
    {
        $totalDiscount = 0.00;
        foreach ($this->offers as $offer) {
            $totalDiscount += $offer->apply($this->items);
        }
        return round($totalDiscount, 2);
    }

    public function getSubTotal(): float
    {
        $total = 0.0;
        foreach ($this->items as $productCode => $quantity) {
            $price = $this->productCatalog->getPrice($productCode);
            $total += $price * $quantity;
        }
        return round($total, 2);
    }

    public function getTotal(): float
    {
        return round($this->getSubTotal() + $this->getDeliveryCost() - $this->getOffers(), 2);
    }
}
