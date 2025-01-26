<?php

namespace Tests;

use App\Entity\Person;
use App\Entity\Product;
use App\Entity\Wallet;
use PHPUnit\Framework\TestCase;

class ExempleTest extends TestCase
{
    public function testGetNamePerson(): void
    {
        $person = new Person('John', 'USD');
        $this->assertEquals('John', $person->getName());
    }
    public function testSetNamePerson(): void
    {
        $person = new Person('John', 'USD');
        $person->setName('Jane');
        $this->assertEquals('Jane', $person->getName());
    }
    public function testGetWalletPerson(): void
    {
        $person = new Person('John', 'USD');
        $this->assertNotNull($person->getWallet());
    }
    public function testSetWalletPerson(): void
    {
        $person = new Person('John', 'USD');
        $person->setWallet(new Wallet('EUR'));
        $this->assertNotNull($person->getWallet());
    }
    public function testHasFundPersonTrue(): void
    {
        $person = new Person('John', 'USD');
        $person->getWallet()->setBalance(100.0);
        $this->assertTrue($person->hasFund());
    }
    public function testHasFundPersonFalse(): void
    {
        $person = new Person('John', 'USD');
        $person->getWallet()->setBalance(0);
        $this->assertFalse($person->hasFund());
    }
    public function testTransfertFundSameCurrency(): void
    {
        $person1 = new Person('John', 'USD');
        $person2 = new Person('Jane', 'USD');
        $person1->getWallet()->setBalance(100.0);
        $person2->getWallet()->setBalance(50.0);
        $person1->transfertFund(50.0, $person2);
        $this->assertEquals(50.0, $person1->getWallet()->getBalance());
        $this->assertEquals(100.0, $person2->getWallet()->getBalance());
    }
    public function testTransfertFundDifferentCurrency(): void
    {
        $this->expectException(\Exception::class);
        $person1 = new Person('John', 'USD');
        $person2 = new Person('Jane', 'EUR');
        $person1->getWallet()->setBalance(100.0);
        $person2->getWallet()->setBalance(50.0);
        $person1->transfertFund(50.0, $person2);
    }
    public function testDivideWallet(): void
    {
        $person1 = new Person('John', 'USD');
        $person2 = new Person('Jane', 'USD');
        $person3 = new Person('Jack', 'USD');
        $person1->getWallet()->setBalance(150.0);
        $persons = [$person2, $person3];
        $person1->divideWallet($persons);
        $this->assertEquals(75, $person2->getWallet()->getBalance());
        $this->assertEquals(75, $person3->getWallet()->getBalance());
        $this->assertEquals(0, $person1->getWallet()->getBalance());
    }
//    public function testDivideWalletDifferentCurrency(): void
//    {
//        $this->expectException(\Exception::class);
//        $person1 = new Person('John', 'USD');
//        $person2 = new Person('Jane', 'EUR');
//        $person3 = new Person('Jack', 'EUR');
//        $person1->getWallet()->setBalance(150.0);
//        $persons = [$person2, $person3];
//        $person1->divideWallet($persons);
//    }
    public function testBuyProduct(): void
    {
        $person = new Person('John', 'USD');
        $product = new Product('Laptop', ['USD' => 1500.0, 'EUR' => 1200.0], 'tech');
        $person->getWallet()->setBalance(1500.0);
        $person->buyProduct($product);
        $this->assertEquals(0.0, $person->getWallet()->getBalance());
    }
    public function testBuyProductDifferentCurrency(): void
    {
        $this->expectException(\Exception::class);
        $person = new Person('John', 'USD');
        $product = new Product('Laptop', ['EUR' => 1200.0], 'tech');
        $person->getWallet()->setBalance(1000.0);
        $person->buyProduct($product);
    }
}
