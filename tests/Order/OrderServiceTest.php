<?php

namespace App\Tests\Order;

use App\Common\Domain\ValueObject\Money;
use App\Order\Domain\Collection\OrderProductCollection;
use App\Order\Domain\Dto\NewOrder;
use App\Order\Domain\Dto\OrderProduct;
use App\Order\Domain\Entity\Order;
use App\Order\Domain\Repository\OrderRepository;
use App\Order\Domain\Service\OrderService;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class OrderServiceTest extends TestCase
{
    public function testCreateOrderSuccessfully()
    {
        $repositoryMock = $this->createMock(OrderRepository::class);
        $repositoryMock
            ->expects($this->once())
            ->method('nextIdentity')
            ->willReturn(Uuid::fromString('123e4567-e89b-12d3-a456-426614174000'));
        $repositoryMock
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Order::class));

        $orderService = new OrderService($repositoryMock);

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

        $orderService->create($newOrder, $productCollection);
    }
}
