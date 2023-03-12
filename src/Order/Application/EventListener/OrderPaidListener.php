<?php

namespace App\Order\Application\EventListener;

use App\Common\Domain\Event\OrderPaidEvent;
use App\Order\Domain\Service\PrepareOrderService;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
class OrderPaidListener
{
    public function __construct(
        private readonly PrepareOrderService $prepareOrder
    ) {
    }

    public function __invoke(OrderPaidEvent $event): void
    {
        // Will assume that the order is ready immediately after payment
        $this->prepareOrder->setPrepared($event->getOrderId());
    }
}
