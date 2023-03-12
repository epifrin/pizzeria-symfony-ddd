<?php

namespace App\Delivery\Domain\Repository;

use App\Delivery\Domain\Entity\Delivery;

interface DeliveryRepository
{
    public function save(Delivery $entity): void;
}
