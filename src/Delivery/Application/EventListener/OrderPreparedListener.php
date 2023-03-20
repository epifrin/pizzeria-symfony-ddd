<?php

namespace App\Delivery\Application\EventListener;

use App\Common\Domain\Event\OrderPreparedEvent;
use App\Delivery\Domain\Service\CreateDeliveryService;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
class OrderPreparedListener
{
    public function __construct(
        private readonly CreateDeliveryService $createDeliveryService
    ) {
    }

    public function __invoke(OrderPreparedEvent $event): void
    {
        $this->createDeliveryService->create(
            $event->getOrderId(),
            $event->getCustomer(),
            $event->getPhone(),
            $event->getDeliveryAddress()
        );
    }
}
