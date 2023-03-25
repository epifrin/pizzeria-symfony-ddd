<?php

namespace App\Tests\Unit\Common;

use App\Common\Domain\ValueObject\Phone;
use PHPUnit\Framework\TestCase;

class PhoneTest extends TestCase
{
    public function testCreateValidPhone(): void
    {
        $phone = new Phone('123456789');
        $this->assertInstanceOf(Phone::class, $phone);
    }

    public function testCreateInvalidEmptyPhone(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Phone('');
    }

    public function testCreateInvalidNonNumericPhone(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Phone('abc');
    }

    public function testCreateInvalidShortPhone(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Phone('12345');
    }

    public function testCreateInvalidLongPhone(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Phone('12345678912345678');
    }
}
