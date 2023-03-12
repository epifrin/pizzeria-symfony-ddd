<?php

namespace App\Common\Domain\Event;

use App\Common\Domain\ValueObject\OrderId;
use App\Common\Domain\ValueObject\Customer;
use App\Common\Domain\ValueObject\Phone;
use Symfony\Contracts\EventDispatcher\Event;

class OrderPreparedEvent extends Event
{
    public function __construct(
        private readonly OrderId $orderId,
        private readonly Customer $customer,
        private readonly Phone $phone,
        private readonly string $deliveryAddress
    ) {
    }

    public function getOrderId(): OrderId
    {
        return $this->orderId;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function getDeliveryAddress(): string
    {
        return $this->deliveryAddress;
    }
}
