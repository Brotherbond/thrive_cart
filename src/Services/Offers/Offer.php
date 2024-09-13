<?php
namespace App\Services\Offers;

abstract class Offer
{
    /**
     * @param array<string, int> $products
     */
    abstract public function apply(array $products): float;
}
