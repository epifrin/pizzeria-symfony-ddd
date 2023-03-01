<?php

namespace App\Product\Infrastructure\Repository;

use App\Product\Domain\ProductRepository;
use App\Product\Domain\ViewModel\Product;

class ProductSqlRepository implements ProductRepository
{
    public function __construct()
    {
    }

    public function getProductList(): array
    {
        // TODO: Implement getProductList() method.
        return [
            new Product(1, 'Carbonara', '', ''),
            new Product(2, 'Havaii', '', 'Ananas'),
        ];
    }
}
