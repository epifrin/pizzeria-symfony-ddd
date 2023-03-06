<?php

namespace App\Order\Domain\ValueObject;

use Webmozart\Assert\Assert;

/** @immutable */
final class Customer
{
    private string $firstname;
    private string $lastname;

    /**
     * @param non-empty-string $firstname
     * @param non-empty-string $lastname
     */
    public function __construct(string $firstname, string $lastname)
    {
        Assert::notEmpty($firstname);
        Assert::notEmpty($lastname);
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }
}
