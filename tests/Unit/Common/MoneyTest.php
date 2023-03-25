<?php

namespace App\Tests\Unit\Common;

use App\Common\Domain\ValueObject\Money;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public function testConstructor(): void
    {
        $money = new Money(1000, 'USD');
        $this->assertEquals(1000, $money->getAmount());
        $this->assertEquals('USD', $money->getCurrency());
    }

    public function testGetNormalizedAmount(): void
    {
        $money = new Money(1000, 'USD');
        $this->assertEquals('10', $money->getNormalizedAmount());
    }

    public function testGetUSD(): void
    {
        $money = new Money(1000, 'USD');
        $this->assertEquals('$10', $money->getUSD());
    }

    public function testAdd(): void
    {
        $money1 = new Money(1000, 'USD');
        $money2 = new Money(500, 'USD');
        $money3 = $money1->add($money2);

        $this->assertEquals(1500, $money3->getAmount());
        $this->assertEquals('USD', $money3->getCurrency());

        $this->expectException(\InvalidArgumentException::class);
        $money4 = new Money(500, 'EUR');
        $money1->add($money4);
    }

    public function testMultiply(): void
    {
        $money = new Money(1000, 'USD');
        $money2 = $money->multiply(3);
        $this->assertEquals(3000, $money2->getAmount());
        $this->assertEquals('USD', $money2->getCurrency());
    }

    public function testSubtract(): void
    {
        $money1 = new Money(1000, 'USD');
        $money2 = new Money(500, 'USD');
        $money3 = $money1->subtract($money2);

        $this->assertEquals(500, $money3->getAmount());
        $this->assertEquals('USD', $money3->getCurrency());

        $this->expectException(\InvalidArgumentException::class);
        $money4 = new Money(500, 'EUR');
        $money1->subtract($money4);
    }

    public function testEquals(): void
    {
        $money1 = new Money(1000, 'USD');
        $money2 = new Money(1000, 'USD');
        $money3 = new Money(500, 'USD');

        $this->assertTrue($money1->equals($money2));
        $this->assertFalse($money1->equals($money3));
    }
}
