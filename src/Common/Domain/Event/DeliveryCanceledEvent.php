<?php

namespace App\Common\Domain\Event;

use App\Common\Domain\ValueObject\OrderId;
use Symfony\Contracts\EventDispatcher\Event;

class DeliveryCanceledEvent extends Event
{
    public function __construct(private readonly OrderId $orderId)
    {
    }

    public function getOrderId(): OrderId
    {
        return $this->orderId;
    }
}
