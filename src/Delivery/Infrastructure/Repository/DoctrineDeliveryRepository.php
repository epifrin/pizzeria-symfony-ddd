<?php

namespace App\Delivery\Infrastructure\Repository;

use App\Common\Domain\ValueObject\OrderId;
use App\Delivery\Domain\Entity\Delivery;
use App\Delivery\Domain\Repository\DeliveryRepository;
use App\Delivery\Domain\ViewModel\DeliveryInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Delivery>
 *
 * @method Delivery|null find($id, $lockMode = null, $lockVersion = null)
 * @method Delivery|null findOneBy(array $criteria, array $orderBy = null)
 * @method Delivery[]    findAll()
 * @method Delivery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class DoctrineDeliveryRepository extends ServiceEntityRepository implements DeliveryRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Delivery::class);
    }

    public function save(Delivery $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function getDeliveryInfoByOrderId(OrderId $orderId): DeliveryInfo
    {
        /** @var false|array{order_id: string, status: int, delivery_address: string} $record */
        $record = $this->getEntityManager()->getConnection()
            ->fetchAssociative(
                'SELECT order_id, status, delivery_address FROM delivery WHERE order_id = :order_id',
                ['order_id' => $orderId]
            );

        if (empty($record)) {
            throw new \DomainException('Delivery with order id ' . $orderId . ' not found');
        }

        return new DeliveryInfo($record['order_id'], $record['status'], $record['delivery_address']);
    }
}
