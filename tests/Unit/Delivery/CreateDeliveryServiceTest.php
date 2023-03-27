<?php

namespace App\Tests\Unit\Delivery;

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
    private ArrayRand $arrayRand;
    private DeliveryRepository $deliveryRepository;
    private EventDispatcherInterface $eventDispatcher;

    public function setUp(): void
    {
        parent::setUp();
        $this->arrayRand = $this->createStub(ArrayRand::class);
        $this->deliveryRepository = $this->createMock(DeliveryRepository::class);
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
    }

    public function testCreateDeliverySuccessfully(): void
    {
        $this->arrayRand
            ->method('rand')
            ->willReturn(0); // return index 0, it's first delivery man John Spider

        $this->deliveryRepository
            ->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(static function (Delivery $delivery) {
                    return $delivery->isStatusInProgress();
                })
            );

        $this->eventDispatcher
            ->expects($this->never())
            ->method('dispatch');

        $createDeliveryService = new CreateDeliveryService(
            $this->arrayRand,
            $this->deliveryRepository,
            $this->eventDispatcher
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
        $orderId = OrderId::fromString('0186bd8e-f203-7ce8-980d-c4afc8a685b0');
        $customer = new Customer('John', 'Smith');
        $phone = new Phone('578934578934');
        $deliveryAddress = '123 Main St';

        $this->arrayRand
            ->method('rand')
            ->willReturn(3); // Returns empty Delivery Man index

        $this->deliveryRepository
            ->expects($this->never())
            ->method('save');

        $this->eventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with($this->equalTo(new DeliveryCanceledEvent($orderId)));

        $createDeliveryService = new CreateDeliveryService(
            $this->arrayRand,
            $this->deliveryRepository,
            $this->eventDispatcher
        );

        $createDeliveryService->create($orderId, $customer, $phone, $deliveryAddress);
    }
}
