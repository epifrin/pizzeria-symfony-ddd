<?php

namespace App\Order\Domain\Service;

use App\Common\Domain\Event\OrderPreparedEvent;
use App\Common\Domain\ValueObject\OrderId;
use App\Order\Domain\Repository\OrderRepository;
use Psr\EventDispatcher\EventDispatcherInterface;

class PrepareOrderService
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function setPrepared(OrderId $orderId): void
    {
        $order = $this->orderRepository->getById($orderId);
        $order->setPrepared();
        $this->orderRepository->save($order);

        $this->eventDispatcher->dispatch(new OrderPreparedEvent(
            $orderId,
            $order->getCustomer(),
            $order->getPhone(),
            $order->getDeliveryAddress()
        ));
    }
}
