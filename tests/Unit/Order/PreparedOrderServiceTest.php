<?php

namespace App\Tests\Unit\Order;

use App\Common\Domain\Event\OrderPreparedEvent;
use App\Common\Domain\ValueObject\Customer;
use App\Common\Domain\ValueObject\OrderId;
use App\Common\Domain\ValueObject\Phone;
use App\Order\Domain\Entity\Order;
use App\Order\Domain\Repository\OrderRepository;
use App\Order\Domain\Service\PrepareOrderService;
use App\Order\Domain\ValueObject\OrderStatus;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;

final class PreparedOrderServiceTest extends TestCase
{
    public function testSetPreparedSuccessfully()
    {
        $orderId = OrderId::fromString('123e4567-e89b-12d3-a456-426614174000');
        $customer = new Customer('firstname', 'lastname');
        $phone = new Phone('738945834435');
        $address = 'New York';

        $order = new Order(
            $orderId,
            $customer,
            $phone,
            $address,
            OrderStatus::NEW
        );

        $repositoryMock = $this->createMock(OrderRepository::class);
        $repositoryMock
            ->expects($this->once())
            ->method('getById')
            ->willReturn($order);

        $repositoryMock
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Order::class));

        $eventDispatcherMock = $this->createMock(EventDispatcherInterface::class);
        $eventDispatcherMock
            ->expects($this->once())
            ->method('dispatch')
            ->with($this->equalTo(new OrderPreparedEvent(
                $orderId,
                $customer,
                $phone,
                $address,
            )));

        $service = new PrepareOrderService($repositoryMock, $eventDispatcherMock);

        $service->setPrepared($orderId);

        $this->assertTrue($order->isPrepared());
    }
}
