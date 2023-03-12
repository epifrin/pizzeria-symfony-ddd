<?php

namespace App\Common\Domain\ValueObject;

use Webmozart\Assert\Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @immutable
 */
#[ORM\Embeddable]
final class Phone
{
    #[ORM\Column(type: "string", length: 16)]
    private string $phone;

    /**
     * @param non-empty-string $phone
     */
    public function __construct(string $phone)
    {
        Assert::notEmpty($phone);
        Assert::numeric($phone);
        Assert::lengthBetween($phone, 6, 16);
        $this->phone = $phone;
    }

    public function __toString()
    {
        return $this->phone;
    }
}
