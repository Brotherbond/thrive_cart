<?php
namespace App\Services\Delivery;

class DeliveryCharge extends Delivery
{
    /** @var array<int, array{minTotal: float, charge: float}> */
    private static array $chargeRules = [
        ['minTotal' => 90, 'charge' => 0.00],
        ['minTotal' => 50, 'charge' => 2.95],
        ['minTotal' => 0, 'charge' => 4.95],
    ];

    public static function calculate(float $basketTotal): float
    {
        foreach (self::$chargeRules as $rule) {
            if ($basketTotal >= $rule['minTotal']) {
                return $rule['charge'];
            }
        }
        return end(self::$chargeRules)['charge'] ?? 0.00;
    }

    public static function addRule(float $minTotal, float $charge): void
    {
        self::$chargeRules[] = ['minTotal' => $minTotal, 'charge' => $charge];
        self::sortRules();
    }

    private static function sortRules(): void
    {
        usort(self::$chargeRules, function ($a, $b) {
            return $b['minTotal'] <=> $a['minTotal'];
        });
    }
}
