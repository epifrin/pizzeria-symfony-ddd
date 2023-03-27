<?php

namespace App\Tests\Unit\Common;

use App\Common\Domain\ValueObject\Customer;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function testCanCreateCustomer(): void
    {
        $customer = new Customer('John', 'Doe');

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertEquals('John', $customer->getFirstname());
        $this->assertEquals('Doe', $customer->getLastname());
    }

    public function testEmptyFirstnameThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Customer('', 'Doe');
    }

    public function testEmptyLastnameThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Customer('John', '');
    }

    public function testFirstnameTooLongThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Customer(str_repeat('a', 51), 'Doe');
    }

    public function testLastnameTooLongThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Customer('John', str_repeat('a', 51));
    }
}
