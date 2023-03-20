<?php

namespace App\Delivery\Domain\ViewModel;

use App\Delivery\Domain\ValueObject\DeliveryStatus;

final class DeliveryInfo
{
    private string $orderId;
    private DeliveryStatus $status;
    private string $address;

    public function __construct(string $orderId, int $status, string $address)
    {
        $this->orderId = $orderId;
        $this->status = DeliveryStatus::from($status);
        $this->address = $address;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function isInProgress(): bool
    {
        return $this->status === DeliveryStatus::IN_PROGRESS;
    }

    public function isDelivered(): bool
    {
        return $this->status === DeliveryStatus::DELIVERED;
    }

    public function getAddress(): string
    {
        return $this->address;
    }
}
