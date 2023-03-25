<?php

namespace App\Tests\Delivery;

use App\Common\Domain\Event\DeliveryCanceledEvent;
use App\Common\Domain\ValueObject\Customer;
use App\Common\Domain\ValueObject\OrderId;
use App\Common\Domain\ValueObject\Phone;
use App\Delivery\Domain\Entity\Delivery;
use App\Delivery\Domain\Repository\DeliveryRepository;
use App\Delivery\Domain\Service\CreateDeliveryService;
use App\Delivery\Infrastructure\Helper\ArrayRand;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;

class CreateDeliveryServiceTest extends TestCase
{
    public function testCreateDeliverySuccessfully(): void
    {
        $arrayRandMock = $this->createStub(ArrayRand::class);
        $arrayRandMock
            ->method('rand')
            ->willReturn(0); // return index 0, it's first delivery man John Spider

        $repositoryMock = $this->createMock(DeliveryRepository::class);
        $repositoryMock
            ->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(static function (Delivery $delivery) {
                    return $delivery->isStatusInProgress();
                })
            );

        $createDeliveryService = new CreateDeliveryService(
            $arrayRandMock,
            $repositoryMock,
            $this->createStub(EventDispatcherInterface::class)
        );

        $orderId = '0186bd8e-f203-7ce8-980d-c4afc8a685b0';
        $createDeliveryService->create(
            OrderId::fromString($orderId),
            new Customer('firstname', 'lastname'),
            new Phone('738945834435'),
            'New York'
        );
    }

    public function testCreateDeliveryWithNoAvailableDeliveryMan()
    {
        // Arrange
        $arrayRandMock = $this->createStub(ArrayRand::class);
        $arrayRandMock
            ->method('rand')
            ->willReturn(3); // Returns null index

        $deliveryRepositoryMock = $this->createMock(DeliveryRepository::class);
        $deliveryRepositoryMock
            ->expects($this->never())
            ->method('save');

        $eventDispatcherMock = $this->createMock(EventDispatcherInterface::class);
        $eventDispatcherMock->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(DeliveryCanceledEvent::class));

        $createDeliveryService = new CreateDeliveryService(
            $arrayRandMock,
            $deliveryRepositoryMock,
            $eventDispatcherMock
        );

        $orderId = OrderId::fromString('0186bd8e-f203-7ce8-980d-c4afc8a685b0');
        $customer = new Customer('John', 'Smith');
        $phone = new Phone('578934578934');
        $deliveryAddress = '123 Main St';

        // Act
        $createDeliveryService->create($orderId, $customer, $phone, $deliveryAddress);
    }
}
