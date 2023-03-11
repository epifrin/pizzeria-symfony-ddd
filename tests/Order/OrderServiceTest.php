<?php

namespace App\Tests\Order;

use App\Common\Domain\Event\OrderPlacedEvent;
use App\Common\Domain\ValueObject\Money;
use App\Common\Domain\ValueObject\OrderId;
use App\Order\Domain\Collection\OrderProductCollection;
use App\Order\Domain\Dto\NewOrder;
use App\Order\Domain\Dto\OrderProduct;
use App\Order\Domain\Entity\Order;
use App\Order\Domain\Repository\OrderRepository;
use App\Order\Domain\Service\OrderService;
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
            ->with($this->equalTo(new OrderPlacedEvent(
                new OrderId(Uuid::fromString($orderId)),
                new Money(2000)
            )));

        $orderService = new OrderService($repositoryMock, $uuidFactoryMock, $eventDispatcherMock);

        $newOrder = new NewOrder();
        $newOrder->firstname = 'John';
        $newOrder->lastname = 'Smith';
        $newOrder->phone = '0667234234';
        $newOrder->deliveryAddress = 'New York';

        $productCollection = new OrderProductCollection();
        $product1 = new OrderProduct();
        $product1->productId = 1;
        $product1->title = 'Product 1';
        $product1->price = new Money(1000);
        $product1->setQuantityAndTotal(2);
        $productCollection->add($product1);

        $returnedOrderId = $orderService->create($newOrder, $productCollection);
        $this->assertEquals($returnedOrderId, $orderId);
    }
}
