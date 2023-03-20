<?php

namespace App\Delivery\Domain\Service;

use App\Common\Domain\Event\DeliveryCanceledEvent;
use App\Common\Domain\ValueObject\OrderId;
use App\Common\Domain\ValueObject\Phone;
use App\Delivery\Domain\Entity\Delivery;
use App\Delivery\Domain\Repository\DeliveryRepository;
use App\Delivery\Infrastructure\Helper\ArrayRand;
use App\Common\Domain\ValueObject\Customer;
use Psr\EventDispatcher\EventDispatcherInterface;

final class CreateDeliveryService
{
    public function __construct(
        private readonly ArrayRand $arrayRand,
        private readonly DeliveryRepository $deliveryRepository,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function create(OrderId $orderId, Customer $customer, Phone $phone, string $deliveryAddress): void
    {
        $deliveryMan = $this->getAvailableDeliveryMan();

        if (is_null($deliveryMan)) {
            $this->eventDispatcher->dispatch(new DeliveryCanceledEvent($orderId));
            return;
        }

        $delivery = Delivery::create($orderId, $customer, $phone, $deliveryAddress);
        $delivery->setDeliveryMan($deliveryMan);
        $delivery->setStatusInProgress();
        $this->deliveryRepository->save($delivery);
    }

    /**
     * Fake method to get available delivery man
     */
    private function getAvailableDeliveryMan(): ?string
    {
        $deliveryMen = ['John Spider', 'Jack Speed', 'Anna Swiftness', null];
        return $deliveryMen[$this->arrayRand->rand($deliveryMen)];
    }
}
