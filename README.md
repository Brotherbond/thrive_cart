# Thrive Cart

This project is a PHP-based shopping cart system that includes product management, basket management, delivery charge calculation, and discount offers. The cart supports flexible delivery charge rules, including custom rules, and can apply offers such as "Buy One Get One Half Off".

## Table of Contents

- [Problem Overview](#problem-overview)
- [Assumptions](#assumptions)
- [Features](#features)
- [Installation](#installation)
- [Test](#test)
- [Usage](#usage)
  - [Basic Setup](#basic-setup)
  - [Adding Products to the Basket](#adding-products-to-the-basket)
  - [Calculating Delivery Charges](#calculating-delivery-charges)
  - [Applying Offers](#applying-offers)
  - [Getting Basket Total](#getting-basket-total)

## Problem Overview

You are tasked with creating a proof of concept for a sales system for Acme Widget Co. They sell three products, and you need to handle:

- Product codes and pricing
- Delivery cost calculations based on total order value
- A special offer: "buy one red widget, get the second half price"

## Assumptions

- Basket items are delivered together.
- Multiple rules could be applied for delivery and offers(discount)

## Features

- **Product Management**: Easily manage products, including their code, name, and price.
- **Basket Functionality**: Add, remove, and manage items in the basket.
- **Delivery Charge Rules**: Define custom delivery charge rules based on the subtotal - total discount applied.
- **Offer Management**: Apply offers such as "Buy One Get One Half Off" or custom offers.
- **Dynamic Calculation**: Calculates the subtotal, total discounts, delivery charges, and final basket total.

## Installation

### Prerequisites

- docker
- PHP 8.3 or higher
- Composer (PHP dependency manager)

### Steps

1. Clone the repository:

   ```bash
   git clone https://github.com/Brotherbond/thrive_cart.git
   cd thrive_cart
   docker-compose up -d #`docker compose up -d` can be used if docker-compose is not set
   ```

## Test

Run the following composer script

```bash
composer phpstan # static analysis
composer test # to run the tests
```

## Usage

### Basic Setup

To get started with Thrive Cart, you need to set up products, create a product catalog, configure delivery charge rules, and define offers. Below is a step-by-step guide:

```php
<?php
use App\Product;
use App\ProductCatalog;
use App\Basket;
use App\Services\Delivery\DeliveryCharge;
use App\Services\Offers\BuyOneGetOneHalfOffOffer;

// Step 1: Create products
$product1 = new Product('R01', 'Red Widget', 32.95);
$product2 = new Product('G01', 'Green Widget', 24.95);

// Step 2: Create a product catalog
$productCatalog = new ProductCatalog($product1, $product2);

// Step 3: Define delivery rules
$deliveryRule = new DeliveryCharge();

// Step 4: Create offers
$bogohalf = new BuyOneGetOneHalfOffOffer($productCatalog);

// Step 5: Create the basket with delivery rules and offers
$basket = new Basket($productCatalog, [$deliveryRule], [$bogohalf]);

// Step 6: Add items to the basket
$basket->add('R01');
$basket->add('R01');
$basket->add('G01');

// Step 7: Calculate totals
echo "Subtotal: " . $basket->getSubTotal() . PHP_EOL;
echo "Offers: -" . $basket->getOffers() . PHP_EOL;
echo "Delivery: " . $basket->getDeliveryCost() . PHP_EOL;
echo "Total: " . $basket->getTotal() . PHP_EOL;

```

#### Adding Products to the Basket

To add a product to the basket, use the add method:

```php
$basket->add('R01');  // Adds one Red Widget to the basket
$basket->add('G01');  // Adds one Green Widget to the basket

```

#### Calculating Delivery Charges

Delivery charges are calculated based on predefined rules:

```php
$deliveryCost = $basket->getDeliveryCost();  // Returns the delivery charge based on the subtotal
```

You can also define custom delivery charge rules:

```php
DeliveryCharge::addRule(120, 0.00);  // Free delivery for orders above $120
```

#### Applying Offers

Offers like "Buy One Get One Half Off" can be applied dynamically:

```php
$totalDiscount = $basket->getOffers();  // Returns total discount applied from all offers
```

#### Getting Basket Total

To get the final total, including products, delivery, and offers:

```php
$total = $basket->getTotal();  // Returns the total cost including delivery and discounts
```
