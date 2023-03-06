<?php

namespace App\Order\Infractructure\Repository;

use App\Order\Domain\Entity\Order;
use App\Order\Domain\Repository\OrderRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @extends ServiceEntityRepository<Order>
 */
final class OrderDoctrineRepository extends ServiceEntityRepository implements OrderRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function save(Order $order): void
    {
        $this->getEntityManager()->persist($order);
        $this->getEntityManager()->flush();
    }

    public function nextIdentity(): UuidInterface
    {
        return Uuid::uuid7();
    }
}
