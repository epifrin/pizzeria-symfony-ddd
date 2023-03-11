<?php

namespace App\Payment\Infrastructure\Repository;

use App\Common\Domain\ValueObject\Money;
use App\Payment\Domain\Entity\Payment;
use App\Payment\Domain\Repository\PaymentRepository;
use App\Payment\Domain\ValueObject\PaymentId;
use App\Payment\Domain\ViewModel\PaymentInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Payment>
 *
 * @method Payment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Payment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Payment[]    findAll()
 * @method Payment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrinePaymentRepository extends ServiceEntityRepository implements PaymentRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Payment::class);
    }

    public function findOneByPaymentId(PaymentId $paymentId): ?Payment
    {
        return $this->findOneBy(['paymentId.paymentId' => $paymentId]);
    }

    public function findOneByOrderId(string $orderId): PaymentInfo
    {
        /** @var false|array{payment_id: string, amount: int} $record */
        $record = $this->getEntityManager()->getConnection()->fetchAssociative(
            'SELECT payment_id, amount FROM payment WHERE order_id = :order_id',
            ['order_id' => $orderId]
        );

        if (empty($record)) {
            throw new \InvalidArgumentException('Payment with order id ' . $orderId . ' is not found');
        }
        return new PaymentInfo($record['payment_id'], new Money($record['amount']));
    }

    public function save(Payment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
