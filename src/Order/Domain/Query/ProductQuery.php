<?php

namespace App\Order\Domain\Query;

use App\Order\Domain\Dto\OrderProduct;

interface ProductQuery
{
    public function getById(int $productId): OrderProduct;
}
