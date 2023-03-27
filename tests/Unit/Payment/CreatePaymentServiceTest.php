<?php

namespace App\Tests\Unit\Payment;

use App\Common\Domain\ValueObject\Money;
use App\Common\Domain\ValueObject\OrderId;
use App\Payment\Domain\Entity\Payment;
use App\Payment\Domain\Repository\PaymentRepository;
use App\Payment\Domain\Service\CreatePaymentService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Factory\UuidFactory;
use Symfony\Component\Uid\Uuid;

class CreatePaymentServiceTest extends TestCase
{
    public function testCreatePaymentSuccessfully()
    {
        $repositoryMock = $this->createMock(PaymentRepository::class);
        $repositoryMock
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Payment::class));

        $paymentId = '0186bd8e-f20d-7ddd-b028-07c1a497559c';
        $uuidFactoryMock = $this->createMock(UuidFactory::class);
        $uuidFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn(Uuid::fromString($paymentId));

        $createPaymentService = new CreatePaymentService($repositoryMock, $uuidFactoryMock);

        $orderId = '0186bd8e-f203-7ce8-980d-c4afc8a685b0';
        $createPaymentService->create(new OrderId(Uuid::fromString($orderId)), new Money(1200));
    }
}
