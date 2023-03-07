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
    #[ORM\Column(type: "guid", name: "paymentId")]
    private Uuid $paymentId;

    public function __construct(Uuid $paymentId)
    {
        $this->paymentId = $paymentId;
    }

    public function __toString(): string
    {
        return $this->paymentId->toRfc4122();
    }
}
