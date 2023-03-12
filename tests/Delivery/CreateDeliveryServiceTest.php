<?php

namespace App\Tests\Delivery;

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
    public function testCreateDeliverySuccessfully()
    {
        $arrayRandMock = $this->createStub(ArrayRand::class);
        $arrayRandMock->method('rand')->willReturn(0);

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
}
