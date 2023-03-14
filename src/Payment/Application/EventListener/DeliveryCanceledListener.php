<?php

namespace App\Payment\Application\EventListener;

use App\Common\Domain\Event\DeliveryCanceledEvent;
use App\Payment\Domain\Service\RefundService;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
class DeliveryCanceledListener
{
    public function __construct(private readonly RefundService $refundService)
    {
    }

    public function __invoke(DeliveryCanceledEvent $event): void
    {
        $this->refundService->refund($event->getOrderId());
    }
}
