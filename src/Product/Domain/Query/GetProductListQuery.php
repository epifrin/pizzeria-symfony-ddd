<?php

namespace App\Product\Domain\Query;

use App\Product\Domain\ProductRepository;

/**
 * Query from CQRS
 */
class GetProductListQuery
{
    public function __construct(
        private readonly ProductRepository $productRepository
    )
    {
    }

    public function getList(): array
    {
        return $this->productRepository->getProductList();
    }
}
