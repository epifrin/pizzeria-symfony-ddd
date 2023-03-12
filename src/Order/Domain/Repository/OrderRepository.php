<?php

namespace App\Order\Domain\Repository;

use App\Common\Domain\ValueObject\OrderId;
use App\Order\Domain\Entity\Order;

interface OrderRepository
{
    public function getById(OrderId $orderId): Order;
    public function save(Order $order): void;
}
