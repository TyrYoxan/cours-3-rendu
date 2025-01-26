<?php

namespace Tests;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testGetNameProduct(): void
    {
        $product = new Product('Laptop', ['USD' => 1500.0, 'EUR' => 1200.0], 'tech');
        $this->assertEquals('Laptop', $product->getName());
    }
    public function testGetPricesProduct(): void
    {
        $product = new Product('Laptop', ['USD' => 1500.0, 'EUR' => 1200.0], 'tech');
        $this->assertEquals(['USD' => 1500.0, 'EUR' => 1200.0], $product->getPrices());
    }
    public function testGetTypeProduct(): void
    {
        $product = new Product('Laptop', ['USD' => 1500.0, 'EUR' => 1200.0], 'tech');
        $this->assertEquals('tech', $product->getType());
    }
    public function testSetTypeProduct(): void
    {
        $product = new Product('Laptop', ['USD' => 1500.0, 'EUR' => 1200.0], 'tech');
        $product->setType('food');
        $this->assertEquals('food', $product->getType());
    }
    public function testSetTypeProductException(): void
    {
        $this->expectException(\Exception::class);
        $product = new Product('Laptop', ['USD' => 1500.0, 'EUR' => 1200.0], 'tech');
        $product->setType('invalidType');
    }
    public function testSetPrices(): void
    {
        $product = new Product('Laptop', [], 'tech');

        $prices = [
            'USD' => 100.0,
            'EUR' => 80.0,
            'GBP' => -20.0,
            'JPY' => 10000.0,
        ];
        $product->setPrices($prices);
        $expectedPrices = [
            'USD' => 100.0,
            'EUR' => 80.0,
        ];
        $this->assertEquals($expectedPrices, $product->getPrices());
    }
    public function testSetPricesNoValidPrices(): void
    {
        $product = new Product('Laptop', [], 'tech');
        $prices = [
            'USD' => 100.0,
            'EUR' => -80.0,
            'GBP' => -20.0,
            'JPY' => 10000.0,
        ];
        $product->setPrices($prices);
        $this->assertEquals(['USD' => 100.0], $product->getPrices());
    }
    public function testSetPricesSingleValidPrice(): void
    {
        $product = new Product('Laptop', [], 'tech');

        $prices = [
            'USD' => 50.0,
            'GBP' => -20.0,
        ];

        $product->setPrices($prices);

        $expectedPrices = ['USD' => 50.0];
        $this->assertEquals($expectedPrices, $product->getPrices());
    }
    public function testGetTVA(): void
    {
        $product = new Product('Laptop', ['USD' => 1500.0, 'EUR' => 1200.0], 'tech');
        $this->assertEquals(0.2, $product->getTVA());
    }
    public function testGetPriceExceptionInvalideCurrency(): void
    {
        $this->expectException(\Exception::class);
        $product = new Product('Laptop', ['USD' => 1500.0, 'EUR' => 1200.0], 'tech');
        $product->getPrice('GBP');
    }
    public function testGetPriceExceptionCurrencyNotAvailable(): void
    {
        $this->expectException(\Exception::class);
        $product = new Product('Laptop', ['USD' => 1500.0], 'tech');
        $product->getPrice('EUR');
    }
}
