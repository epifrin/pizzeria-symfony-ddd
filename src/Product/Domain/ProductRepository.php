<?php

namespace App\Product\Domain;

use App\Product\Domain\ViewModel\Product;

interface ProductRepository
{
    /**
     * @return Product[]
     */
    public function getProductList(): array;
}
