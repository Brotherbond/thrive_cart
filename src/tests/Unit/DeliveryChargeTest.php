<?php
use App\Services\Delivery\DeliveryCharge;
use PHPUnit\Framework\TestCase;

class DeliveryChargeTest extends TestCase
{
    public function testDeliveryChargeCalculation(): void
    {
        $this->assertEquals(0.00, DeliveryCharge::calculate(100.00));
        $this->assertEquals(2.95, DeliveryCharge::calculate(60.00));
        $this->assertEquals(4.95, DeliveryCharge::calculate(30.00));
    }

    public function testAddingNewRule(): void
    {
        DeliveryCharge::addRule(120.00, 0.00);
        $this->assertEquals(0.00, DeliveryCharge::calculate(130.00));
    }
}
