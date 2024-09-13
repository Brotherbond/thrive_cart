<?php
namespace App;

class Product
{
    private string $code, $name;
    private float $price;
    public function __construct(string $code, string $name, float $price)
    {
        $this->code = $code;
        $this->name = $name;
        $this->price = $price;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
