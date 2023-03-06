<?php

namespace App\Product\Domain\Repository;

use App\Product\Domain\ViewModel\Product;

interface ProductRepository
{
    /**
     * @return Product[]
     */
    public function getProductList(): array;
}
