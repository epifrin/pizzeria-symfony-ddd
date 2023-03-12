<?php

namespace App\Common\Domain\Event;

use App\Common\Domain\ValueObject\Money;
use App\Common\Domain\ValueObject\OrderId;
use Symfony\Contracts\EventDispatcher\Event;

final class OrderCreatedEvent extends Event
{
    public function __construct(
        private OrderId $orderId,
        private Money $totalAmount
    ) {
    }

    public function getOrderId(): OrderId
    {
        return $this->orderId;
    }

    public function getTotalAmount(): Money
    {
        return $this->totalAmount;
    }
}
