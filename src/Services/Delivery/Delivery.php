<?php
namespace App\Services\Delivery;

abstract class Delivery
{
    abstract public static function calculate(float $subTotal): float;
}
