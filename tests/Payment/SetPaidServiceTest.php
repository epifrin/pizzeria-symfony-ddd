<?php

namespace App\Tests\Payment;

use App\Common\Domain\Event\OrderPaidEvent;
use App\Common\Domain\ValueObject\OrderId;
use App\Payment\Domain\Entity\Payment;
use App\Payment\Domain\Repository\PaymentRepository;
use App\Payment\Domain\Service\SetPaidService;
use App\Payment\Domain\ValueObject\PaymentId;
use App\Payment\Domain\ValueObject\PaymentStatus;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Uid\Uuid;

class SetPaidServiceTest extends TestCase
{
    public function testSetPaidSuccessfully()
    {
        $paymentId = '0186bd8e-f20d-7ddd-b028-07c1a497559c';
        $orderId = '0186bd8e-f203-7ce8-980d-c4afc8a685b0';
        $repositoryMock = $this->createMock(PaymentRepository::class);
        $repositoryMock
            ->expects($this->once())
            ->method('findOneByPaymentId')
            ->willReturn(new Payment(
                PaymentId::fromString($paymentId),
                OrderId::fromString($orderId),
                1200,
                PaymentStatus::NEW
            ));
        $repositoryMock
            ->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(static function (Payment $payment) {
                    return $payment->isStatusPaid();
                })
            );

        $eventDispatcherMock = $this->createMock(EventDispatcherInterface::class);
        $eventDispatcherMock
            ->expects($this->once())
            ->method('dispatch')
            ->with($this->equalTo(new OrderPaidEvent(
                new OrderId(Uuid::fromString($orderId)),
            )));

        $service = new SetPaidService($repositoryMock, $eventDispatcherMock);
        $this->assertTrue($service->setPaid(PaymentId::fromString($paymentId)));
    }

    public function testPaymentNotFound()
    {
        $paymentId = '0186bd8e-f20d-7ddd-b028-07c1a497559c';
        $this->expectExceptionMessage('Payment ' . $paymentId . ' not found');
        $repositoryMock = $this->createMock(PaymentRepository::class);
        $repositoryMock
            ->expects($this->once())
            ->method('findOneByPaymentId')
            ->willReturn(null);
        $repositoryMock
            ->expects($this->never())
            ->method('save');

        $service = new SetPaidService($repositoryMock, $this->createStub(EventDispatcherInterface::class));
        $service->setPaid(PaymentId::fromString($paymentId));
    }

    public function testPaymentAlreadyPaid()
    {
        $paymentId = '0186bd8e-f20d-7ddd-b028-07c1a497559c';
        $orderId = '0186bd8e-f203-7ce8-980d-c4afc8a685b0';
        $this->expectExceptionMessage('Payment ' . $paymentId . ' status is not NEW');
        $repositoryMock = $this->createMock(PaymentRepository::class);
        $repositoryMock
            ->expects($this->once())
            ->method('findOneByPaymentId')
            ->willReturn(new Payment(
                PaymentId::fromString($paymentId),
                OrderId::fromString($orderId),
                1200,
                PaymentStatus::PAID
            ));
        $repositoryMock
            ->expects($this->never())
            ->method('save');

        $service = new SetPaidService($repositoryMock, $this->createStub(EventDispatcherInterface::class));
        $service->setPaid(PaymentId::fromString($paymentId));
    }
}
