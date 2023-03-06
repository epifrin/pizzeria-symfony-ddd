<?php

namespace App\Order\Domain\ValueObject;

use Webmozart\Assert\Assert;

/** @immutable */
final class Phone
{
    private string $phone;

    /**
     * @param non-empty-string $phone
     */
    public function __construct(string $phone)
    {
        Assert::notEmpty($phone);
        Assert::numeric($phone);
        $this->phone = $phone;
    }

    public function __toString()
    {
        return $this->phone;
    }
}
