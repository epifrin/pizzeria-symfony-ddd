<?php

namespace App\Payment\Infrastructure\Repository;

use App\Common\Domain\ValueObject\Money;
use App\Common\Domain\ValueObject\OrderId;
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

    public function findOneByOrderId(OrderId $orderId): ?Payment
    {
        return $this->findOneBy(['orderId.orderId' => $orderId]);
    }

    public function getPaymentInfoByOrderId(string $orderId): PaymentInfo
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

    public function getOrderIdByPaymentId(PaymentId $paymentId): string
    {
        /** @var string|false $result */
        $result = $this->getEntityManager()->getConnection()->fetchOne(
            'SELECT order_id FROM payment WHERE payment_id = :payment_id',
            ['payment_id' => $paymentId]
        );
        if (!$result) {
            throw new \InvalidArgumentException('Payment with id ' . $paymentId . ' is not found');
        }
        return $result;
    }

    public function save(Payment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
