<?php

namespace App\Order\Application\EventListener;

use App\Common\Domain\Event\OrderDeliveredEvent;
use App\Order\Domain\Service\OrderDoneService;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
final class OrderDeliveredListener
{
    public function __construct(
        private readonly OrderDoneService $orderDoneService
    ) {
    }

    public function __invoke(OrderDeliveredEvent $event): void
    {
        $this->orderDoneService->delivered($event->getOrderId());
    }
}
