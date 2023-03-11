<?php

namespace App\Payment\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @immutable
 */
#[ORM\Embeddable]
class PaymentId
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Column(type: "guid")]
    private string $paymentId;

    public function __construct(Uuid $paymentId)
    {
        $this->paymentId = $paymentId;
    }

    public static function fromString(string $paymentId): PaymentId
    {
        return new self(Uuid::fromString($paymentId));
    }

    public function __toString(): string
    {
        return $this->paymentId;
    }
}
