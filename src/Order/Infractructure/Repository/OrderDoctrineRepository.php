<?php

namespace App\Order\Infractructure\Repository;

use App\Order\Domain\Entity\Order;
use App\Order\Domain\Repository\OrderRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @extends ServiceEntityRepository<Order>
 */
final class OrderDoctrineRepository extends ServiceEntityRepository implements OrderRepository
{
    public function save(Order $order): void
    {
        // TODO: Implement save() method.
    }

    public function nextIdentity(): UuidInterface
    {
        return Uuid::uuid7();
    }
}
