<?php

namespace App\Order\Domain\Service;

use App\Common\Domain\Event\OrderPlacedEvent;
use App\Order\Domain\Collection\OrderProductCollection;
use App\Order\Domain\Dto\NewOrder;
use App\Order\Domain\Entity\Order;
use App\Order\Domain\Repository\OrderRepository;
use App\Order\Domain\ValueObject\Customer;
use App\Common\Domain\ValueObject\OrderId;
use App\Order\Domain\ValueObject\OrderStatus;
use App\Order\Domain\ValueObject\Phone;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Uid\Factory\UuidFactory;

final class OrderService
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly UuidFactory $uuidFactory,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function create(NewOrder $newOrder, OrderProductCollection $orderProducts): string
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
            new OrderPlacedEvent($order->getOrderId(), $order->getTotalAmount())
        );

        return $order->getOrderId();
    }
}
