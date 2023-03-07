<?php

namespace App\Payment\Domain\Entity;

use App\Common\Domain\ValueObject\Money;
use App\Common\Domain\ValueObject\OrderId;
use App\Payment\Domain\Repository\PaymentRepository;
use App\Payment\Domain\ValueObject\PaymentId;
use App\Payment\Domain\ValueObject\PaymentStatus;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]  /* @phpstan-ignore-line */
class Payment
{
    #[ORM\Id]
    #[ORM\Embedded(class: PaymentId::class)]
    #[ORM\Column]
    private PaymentId $paymentId;

    #[ORM\Embedded(class: OrderId::class, columnPrefix: false)]
    private OrderId $orderId;

    #[ORM\Column(type: "integer")]
    private int $amount;

    #[ORM\Column(type: "integer", enumType: PaymentStatus::class)]
    private PaymentStatus $status;

    #[ORM\Column(type: "datetime", nullable: true)]
    private $paidAt;

    public function setPaymentId(PaymentId $paymentId): void
    {
        $this->paymentId = $paymentId;
    }

    public function setOrderId(OrderId $orderId): void
    {
        $this->orderId = $orderId;
    }

    public function setAmount(Money $amount): void
    {
        $this->amount = $amount->getAmount();
    }

    public function setStatus(PaymentStatus $status): void
    {
        $this->status = $status;
    }
}
