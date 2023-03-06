<?php

namespace App\Product\Domain\Query;

use App\Product\Domain\Repository\ProductRepository;
use App\Product\Domain\ViewModel\Product;

final class GetProductListQuery
{
    public function __construct(
        private readonly ProductRepository $productRepository
    ) {
    }

    /**
     * @return Product[]
     */
    public function getList(): array
    {
        return $this->productRepository->getProductList();
    }
}
