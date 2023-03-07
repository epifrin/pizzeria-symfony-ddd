<?php

namespace App\Order\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @immutable
 */
#[ORM\Embeddable]
final class OrderId
{
    #[ORM\Column(type: "guid", name: "orderId")]
    private Uuid $orderId;

    public function __construct(Uuid $orderId)
    {
        $this->orderId = $orderId;
    }

    public function __toString(): string
    {
        return $this->orderId->toRfc4122();
    }
}
