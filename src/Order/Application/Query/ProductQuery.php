<?php

namespace App\Order\Application\Query;

use App\Order\Application\OrderProductsData;
use App\Order\Domain\Collection\ProductCollection;

interface ProductQuery
{
    public function getProducts(OrderProductsData $products): ProductCollection;
}
