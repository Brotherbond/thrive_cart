# Thrive Cart

This project is a PHP-based shopping cart system that includes product management, basket management, delivery charge calculation, and discount offers. The cart supports flexible delivery charge rules, including custom rules, and can apply offers such as "Buy One Get One Half Off".

## Table of Contents

- [Problem Overview](#problem-overview)
- [Assumptions](#assumptions)
- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)

## Problem Overview
You are tasked with creating a proof of concept for a sales system for Acme Widget Co. They sell three products, and you need to handle:

Product codes and pricing
Delivery cost calculations based on total order value
A special offer: "buy one red widget, get the second half price"

## Assumptions


## Features

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

## Usage

### Basic Setup

To get started with Thrive Cart, you need to set up products, create a product catalog, configure delivery charge rules, and define offers. Below is a step-by-step guide:

