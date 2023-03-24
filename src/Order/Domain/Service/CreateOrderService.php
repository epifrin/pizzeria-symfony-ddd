<?php

namespace App\Order\Domain\Service;

use App\Common\Domain\Event\OrderCreatedEvent;
use App\Order\Domain\Collection\ProductCollection;
use App\Order\Domain\Dto\NewOrder;
use App\Order\Domain\Entity\Order;
use App\Order\Domain\Repository\OrderRepository;
use App\Common\Domain\ValueObject\Customer;
use App\Common\Domain\ValueObject\OrderId;
use App\Order\Domain\ValueObject\OrderStatus;
use App\Common\Domain\ValueObject\Phone;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Uid\Factory\UuidFactory;

final class CreateOrderService
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly UuidFactory $uuidFactory,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function create(NewOrder $newOrder, ProductCollection $orderProducts): string
    {
        $order = new Order(
            new OrderId($this->uuidFactory->create()),
            new Customer($newOrder->firstname, $newOrder->lastname),
            new Phone($newOrder->phone),
            $newOrder->deliveryAddress,
            OrderStatus::NEW
        );

        foreach ($orderProducts as $product) {
            $order->addItem($product);
        }

        $this->orderRepository->save($order);

        $this->eventDispatcher->dispatch(
            new OrderCreatedEvent($order->getOrderId(), $order->getTotalAmount())
        );

        return $order->getOrderId();
    }
}
