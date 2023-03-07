<?php

namespace App\Payment\Application\EventListener;

use App\Common\Domain\Event\OrderPlacedEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
class OrderPlacedListener
{
    public function __construct()
    {
    }

    public function __invoke(OrderPlacedEvent $event): void
    {
        // create payment
    }
}
