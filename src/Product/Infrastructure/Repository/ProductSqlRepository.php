<?php

namespace App\Product\Infrastructure\Repository;

use App\Product\Domain\ProductRepository;
use App\Product\Domain\ViewModel\Product;
use Doctrine\DBAL\Connection;

final class ProductSqlRepository implements ProductRepository
{
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * @return Product[]
     */
    public function getProductList(): array
    {
        // TODO: rewrite in more efficient way
        $query = $this
            ->connection
            ->fetchAllAssociative('SELECT product_id, title, image, price, description FROM product');

        $result = [];
        foreach ($query as $item) {
            $result[] = new Product($item['product_id'], $item['title'], $item['price'], $item['image'], $item['description']);
        }
        return $result;
    }
}
