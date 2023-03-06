<?php

namespace App\Order\Domain\Service;

use App\Order\Domain\Collection\OrderProductCollection;
use App\Order\Domain\Dto\NewOrder;
use App\Order\Domain\Entity\Order;
use App\Order\Domain\Repository\OrderRepository;
use App\Order\Domain\ValueObject\Customer;
use App\Order\Domain\ValueObject\OrderId;
use App\Order\Domain\ValueObject\OrderStatus;
use App\Order\Domain\ValueObject\Phone;

final class OrderService
{
    public function __construct(
        private readonly OrderRepository $orderRepository
    ) {
    }

    public function create(NewOrder $newOrder, OrderProductCollection $orderProducts): void
    {
        $order = new Order(
            new OrderId($this->orderRepository->nextIdentity()),
            new Customer($newOrder->firstname, $newOrder->lastname),
            new Phone($newOrder->phone),
            $newOrder->deliveryAddress,
            OrderStatus::NEW
        );

        foreach ($orderProducts as $product) {
            $order->addItem($product);
        }

        $this->orderRepository->save($order);

        //return $order->getOrderId();
    }
}
