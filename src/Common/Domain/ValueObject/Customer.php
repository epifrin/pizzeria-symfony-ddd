<?php

namespace App\Common\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/** @immutable */
#[ORM\Embeddable]
final class Customer
{
    #[ORM\Column(type: "string", length: 50)]
    private string $firstname;
    #[ORM\Column(type: "string", length: 50)]
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
