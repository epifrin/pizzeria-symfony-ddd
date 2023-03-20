<?php

namespace App\Order\Domain\Service;

use App\Common\Domain\ValueObject\OrderId;
use App\Order\Domain\Repository\OrderRepository;

class OrderDoneService
{
    public function __construct(
        private readonly OrderRepository $orderRepository
    ) {
    }

    public function delivered(OrderId $orderId): void
    {
        $order = $this->orderRepository->getById($orderId);
        $order->setDelivered();
        $this->orderRepository->save($order);
    }
}
