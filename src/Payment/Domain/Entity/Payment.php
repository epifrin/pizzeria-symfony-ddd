<?php

namespace App\Payment\Domain\Entity;

use App\Common\Domain\ValueObject\OrderId;
use App\Payment\Domain\Repository\PaymentRepository;
use App\Payment\Domain\ValueObject\PaymentId;
use App\Payment\Domain\ValueObject\PaymentStatus;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]  /* @phpstan-ignore-line */
class Payment
{
    #[ORM\Embedded(class: PaymentId::class, columnPrefix: false)]
    private PaymentId $paymentId;

    #[ORM\Embedded(class: OrderId::class, columnPrefix: false)]
    private OrderId $orderId;

    #[ORM\Column(type: "integer")]
    private int $amount;

    #[ORM\Column(type: "integer", enumType: PaymentStatus::class)]
    private PaymentStatus $status;

    #[ORM\Column(type: "datetime_immutable", nullable: true)]
    private \DateTimeImmutable $paidAt;

    public function __construct(PaymentId $paymentId, OrderId $orderId, int $amount, PaymentStatus $status)
    {
        $this->paymentId = $paymentId;
        $this->orderId = $orderId;
        $this->amount = $amount;
        $this->status = $status;
    }

    public function isStatusNew(): bool
    {
        return $this->status === PaymentStatus::NEW;
    }

    public function isStatusPaid(): bool
    {
        return $this->status === PaymentStatus::PAID;
    }

    public function setPaid(): void
    {
        $this->status = PaymentStatus::PAID;
        $this->paidAt = new \DateTimeImmutable();
    }

    public function setRefund(): void
    {
        $this->status = PaymentStatus::REFUND;
    }

    public function getOrderId(): OrderId
    {
        return $this->orderId;
    }
}
