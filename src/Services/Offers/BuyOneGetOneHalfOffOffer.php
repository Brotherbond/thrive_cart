<?php
namespace App\Services\Offers;

use App\ProductCatalog;

class BuyOneGetOneHalfOffOffer extends Offer
{
    private string $code;
    private float $price;

    public function __construct(ProductCatalog $productCatalog, string $code = 'R01')
    {
        $this->code = $code;
        $this->price = $productCatalog->getPrice($this->code);
    }

    public function apply(array $basket): float
    {
        $redWidgetCount =
        array_key_exists($this->code, $basket) ? $basket[$this->code] : 0;
        $discount = floor($redWidgetCount / 2) * ($this->price / 2);
        return $discount;
    }
}
