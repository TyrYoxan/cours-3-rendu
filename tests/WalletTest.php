<?php

namespace Tests;

use App\Entity\Wallet;
use PHPUnit\Framework\TestCase;

class WalletTest extends TestCase
{
    public function testSetBalanceException(): void
    {
        $this->expectException(\Exception::class);
        $wallet = new Wallet('EUR');
        $wallet->setBalance(-50.0);
    }
    public function testGetBalance(): void
    {
        $wallet = new Wallet('EUR');
        $wallet->setBalance(50.0);
        $this->assertEquals(50.0, $wallet->getBalance());
    }
    public function testSetCurrency(): void
    {
        $wallet = new Wallet('EUR');
        $wallet->setCurrency('USD');
        $this->assertEquals('USD', $wallet->getCurrency());
    }
    public function testGetCurrency(): void
    {
        $wallet = new Wallet('EUR');
        $this->assertEquals('EUR', $wallet->getCurrency());
    }
    public function testSetCurrencyException(): void
    {
        $this->expectException(\Exception::class);
        $wallet = new Wallet('EUR');
        $wallet->setCurrency('invalidCurrency');
    }
    public function testRemoveFundExceptionEnvalideAmount(): void
    {
        $this->expectException(\Exception::class);
        $wallet = new Wallet('EUR');
        $wallet->setBalance(50.0);
        $wallet->removeFund(-25.0);
    }
    public function testRemoveFundException(): void
    {
        $this->expectException(\Exception::class);
        $wallet = new Wallet('EUR');
        $wallet->removeFund(100.0);
    }
    public function testAddFund(): void
    {
        $wallet = new Wallet('EUR');
        $wallet->setBalance(50.0);
        $wallet->addFund(25.0);
        $this->assertEquals(75.0, $wallet->getBalance());
    }
    public function testAddFundException(): void
    {
        $this->expectException(\Exception::class);
        $wallet = new Wallet('EUR');
        $wallet->addFund(-100.0);
    }
}
