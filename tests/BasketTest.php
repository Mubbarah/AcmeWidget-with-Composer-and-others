<?php

// tests/BasketTest.php
namespace AcmeWidget\Tests;

use PHPUnit\Framework\TestCase;
use AcmeWidget\ProductCatalogue;
use AcmeWidget\Basket;
use AcmeWidget\Product;
use AcmeWidget\DeliveryCalculator;

class BasketTest extends TestCase {
    public function testSubtotalWhenEmpty() {
        $catalogue = new ProductCatalogue();
        $deliveryCalculator = new DeliveryCalculator([50 => 4.95, 90 => 2.95]);
        $offers = null; // Provide a placeholder value for the third argument
        $basket = new Basket($catalogue, $deliveryCalculator, $offers);

        $this->assertEquals(0, $basket->subtotal());
    }

    public function testDeliveryCharge() {
        $catalogue = new ProductCatalogue();
        $catalogue->addProduct(new Product('R01', 'Red Widget', 32.95));
        $deliveryCalculator = new DeliveryCalculator([50 => 4.95, 90 => 2.95]);
        $offers = null; // Provide a placeholder value for the third argument
        $basket = new Basket($catalogue, $deliveryCalculator, $offers);

        $basket->add('R01'); // Add a Red Widget
        $this->assertEquals(4.95, $basket->deliveryCharge());
    }
}

?>