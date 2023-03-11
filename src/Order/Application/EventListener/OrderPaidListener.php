<?php

namespace App\Order\Application\EventListener;

use App\Common\Domain\Event\OrderPaidEvent;
use App\Order\Domain\Repository\OrderRepository;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
class OrderPaidListener
{
    public function __construct(
        private readonly OrderRepository $orderRepository
    ) {
    }

    public function __invoke(OrderPaidEvent $event): void
    {
        $order = $this->orderRepository->findOneBy(['orderId.orderId' => $event->getOrderId()]);
        if (is_null($order)) {
            throw new \DomainException('Order ' . $event->getOrderId() . ' is not found');
        }
        $order->setPaid();
        $this->orderRepository->save($order);
    }
}
