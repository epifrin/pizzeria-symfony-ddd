<?php

namespace App\Common\Domain\Event;

use App\Common\Domain\ValueObject\Money;
use Symfony\Contracts\EventDispatcher\Event;

final class OrderPlacedEvent extends Event
{
    public function __construct(
        private string $orderId,
        private Money $totalAmount
    ) {
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function getTotalAmount(): Money
    {
        return $this->totalAmount;
    }
}
