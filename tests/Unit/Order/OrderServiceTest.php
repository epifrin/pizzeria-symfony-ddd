<?php

namespace App\Tests\Unit\Order;

use App\Common\Domain\Event\OrderCreatedEvent;
use App\Common\Domain\ValueObject\Money;
use App\Common\Domain\ValueObject\OrderId;
use App\Order\Domain\Collection\ProductCollection;
use App\Order\Domain\Dto\NewOrder;
use App\Order\Domain\Entity\Order;
use App\Order\Domain\ReadModel\Product;
use App\Order\Domain\Repository\OrderRepository;
use App\Order\Domain\Service\CreateOrderService;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Uid\Factory\UuidFactory;
use Symfony\Component\Uid\Uuid;

final class OrderServiceTest extends TestCase
{
    public function testCreateOrderSuccessfully()
    {
        $repositoryMock = $this->createMock(OrderRepository::class);
        $repositoryMock
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Order::class));

        $orderId = '123e4567-e89b-12d3-a456-426614174000';
        $uuidFactoryMock = $this->createMock(UuidFactory::class);
        $uuidFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn(Uuid::fromString($orderId));

        $eventDispatcherMock = $this->createMock(EventDispatcherInterface::class);
        $eventDispatcherMock
            ->expects($this->once())
            ->method('dispatch')
            ->with($this->equalTo(new OrderCreatedEvent(
                new OrderId(Uuid::fromString($orderId)),
                new Money(2000)
            )));

        $orderService = new CreateOrderService($repositoryMock, $uuidFactoryMock, $eventDispatcherMock);

        $newOrder = new NewOrder();
        $newOrder->firstname = 'John';
        $newOrder->lastname = 'Smith';
        $newOrder->phone = '0667234234';
        $newOrder->deliveryAddress = 'New York';

        $productCollection = new ProductCollection();
        $product1 = new Product(1, 2, 1000, 'Product 1');
        $productCollection->add($product1);

        $returnedOrderId = $orderService->create($newOrder, $productCollection);
        $this->assertEquals($returnedOrderId, $orderId);
    }
}
