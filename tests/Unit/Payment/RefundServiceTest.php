<?php

namespace App\Tests\Unit\Payment;

use App\Common\Domain\ValueObject\OrderId;
use App\Payment\Domain\Entity\Payment;
use App\Payment\Domain\Repository\PaymentRepository;
use App\Payment\Domain\Service\RefundService;
use App\Payment\Domain\ValueObject\PaymentId;
use App\Payment\Domain\ValueObject\PaymentStatus;
use PHPUnit\Framework\TestCase;

class RefundServiceTest extends TestCase
{
    private PaymentRepository $paymentRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->paymentRepository = $this->createMock(PaymentRepository::class);
    }

    public function testRefundWithExistingPayment(): void
    {
        $orderId = OrderId::fromString('123e4567-e89b-12d3-a456-426614174000');
        $payment = new Payment(
            PaymentId::fromString('0186bd8e-f20d-7ddd-b028-07c1a497559c'),
            $orderId,
            1000,
            PaymentStatus::PAID
        );
        $this->paymentRepository->expects($this->once())
            ->method('findOneByOrderId')
            ->with($orderId)
            ->willReturn($payment);

        $refundService = new RefundService($this->paymentRepository);
        $refundService->refund($orderId);

        $this->assertTrue($payment->isRefunded());
        $this->assertInstanceOf(Payment::class, $payment);
    }

    public function testRefundWithNotPaidPayment(): void
    {
        $orderId = OrderId::fromString('123e4567-e89b-12d3-a456-426614174000');
        $payment = new Payment(
            PaymentId::fromString('0186bd8e-f20d-7ddd-b028-07c1a497559c'),
            $orderId,
            1000,
            PaymentStatus::NEW
        );
        $this->paymentRepository->expects($this->once())
            ->method('findOneByOrderId')
            ->with($orderId)
            ->willReturn($payment);

        $refundService = new RefundService($this->paymentRepository);
        $this->expectException(\DomainException::class);
        $refundService->refund($orderId);
    }

    public function testRefundWithNonExistingPayment(): void
    {
        $orderId = OrderId::fromString('123e4567-e89b-12d3-a456-426614174000');
        $this->paymentRepository->expects($this->once())
            ->method('findOneByOrderId')
            ->with($orderId)
            ->willReturn(null);

        $refundService = new RefundService($this->paymentRepository);
        $this->expectException(\DomainException::class);
        $refundService->refund($orderId);
    }
}
