<?php

namespace App\Order\Domain\Service;

use App\Common\Domain\ValueObject\OrderId;
use App\Order\Domain\Repository\OrderRepository;

class CancelOrderService
{
    public function __construct(
        private readonly OrderRepository $orderRepository
    ) {
    }

    public function cancel(OrderId $orderId): void
    {
        $order = $this->orderRepository->getById($orderId);
        $order->setCancel();
        $this->orderRepository->save($order);
    }
}
