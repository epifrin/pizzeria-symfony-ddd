<?php

namespace App\Order\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @immutable
 */
#[ORM\Embeddable]
final class OrderId
{
    #[ORM\Column(type: "guid", name: "orderId")]
    private UuidInterface $orderId;

    public function __construct(UuidInterface $orderId)
    {
        $this->orderId = $orderId;
    }

    public function __toString(): string
    {
        return $this->orderId->toString();
    }
}
