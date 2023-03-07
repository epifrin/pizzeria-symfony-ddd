<?php

namespace App\Payment\Domain\Repository;

use App\Payment\Domain\Entity\Payment;

interface PaymentRepository
{
    public function save(Payment $entity, bool $flush = false): void;
}
