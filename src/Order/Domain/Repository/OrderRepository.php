<?php

namespace App\Order\Domain\Repository;

use App\Order\Domain\Entity\Order;
use Ramsey\Uuid\UuidInterface;

interface OrderRepository
{
    public function save(Order $order): void;

    public function nextIdentity(): UuidInterface;
}
