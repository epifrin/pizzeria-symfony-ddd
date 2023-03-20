<?php

namespace App\Delivery\Domain\Repository;

use App\Common\Domain\ValueObject\OrderId;
use App\Delivery\Domain\Entity\Delivery;
use App\Delivery\Domain\ViewModel\DeliveryInfo;

interface DeliveryRepository
{
    public function save(Delivery $entity): void;

    public function getDeliveryInfoByOrderId(OrderId $orderId): DeliveryInfo;
}
