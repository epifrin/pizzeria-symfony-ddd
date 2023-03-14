<?php

namespace App\Order\Application\EventListener;

use App\Common\Domain\Event\DeliveryCanceledEvent;
use App\Order\Domain\Service\CancelOrderService;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
class DeliveryCanceledListener
{
    public function __construct(
        private readonly CancelOrderService $cancelOrderService
    ) {
    }

    public function __invoke(DeliveryCanceledEvent $event): void
    {
        $this->cancelOrderService->cancel($event->getOrderId());
    }
}
