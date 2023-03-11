<?php

namespace App\Common\Domain\Event;

use App\Common\Domain\ValueObject\OrderId;
use Symfony\Contracts\EventDispatcher\Event;

class OrderPaidEvent extends Event
{
    public function __construct(
        private OrderId $orderId,
    ) {
    }

    public function getOrderId(): OrderId
    {
        return $this->orderId;
    }
}
