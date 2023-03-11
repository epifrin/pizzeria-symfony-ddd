<?php

namespace App\Common\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @immutable
 */
#[ORM\Embeddable]
final class OrderId
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Column(type: "guid")]
    private string $orderId;

    public function __construct(Uuid $orderId)
    {
        $this->orderId = $orderId;
    }

    public static function fromString(string $orderId): OrderId
    {
        return new self(Uuid::fromString($orderId));
    }

    public function __toString(): string
    {
        return $this->orderId;
    }
}
