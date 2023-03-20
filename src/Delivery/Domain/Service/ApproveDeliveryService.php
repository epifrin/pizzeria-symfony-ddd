<?php

namespace App\Delivery\Domain\Service;

use App\Common\Domain\Event\OrderDeliveredEvent;
use App\Common\Domain\ValueObject\OrderId;
use App\Delivery\Domain\Repository\DeliveryRepository;
use Psr\EventDispatcher\EventDispatcherInterface;

final class ApproveDeliveryService
{
    public function __construct(
        private readonly DeliveryRepository $deliveryRepository,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function approve(OrderId $orderId): void
    {
        $delivery = $this->deliveryRepository->findOneBy(['orderId.orderId' => $orderId]);
        if (is_null($delivery)) {
            throw new \InvalidArgumentException('Delivery with order id ' . $orderId . ' not found');
        }
        if ($delivery->isStatusDelivered() === false) {
            $delivery->setStatusDelivered();

            $this->eventDispatcher->dispatch(new OrderDeliveredEvent($orderId));
        }

        $this->deliveryRepository->save($delivery);
    }
}
