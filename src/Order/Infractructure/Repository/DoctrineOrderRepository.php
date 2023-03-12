<?php

namespace App\Order\Infractructure\Repository;

use App\Common\Domain\ValueObject\OrderId;
use App\Order\Domain\Entity\Order;
use App\Order\Domain\Repository\OrderRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class DoctrineOrderRepository extends ServiceEntityRepository implements OrderRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function getById(OrderId $orderId): Order
    {
        return
            $this->findOneBy(['orderId.orderId' => $orderId])
            ?? throw new \DomainException('Order ' . $orderId . ' is not found');
    }

    public function save(Order $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }
}
