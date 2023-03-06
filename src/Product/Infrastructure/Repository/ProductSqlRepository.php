<?php

namespace App\Product\Infrastructure\Repository;

use App\Product\Domain\Repository\ProductRepository;
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
            ->fetchAllAssociative('SELECT product_id, title, price, image, description FROM product');

        $result = [];
        /** @var array{product_id:string, title:string, price:string, image:string, description:string} $item */
        foreach ($query as $item) {
            $result[] = new Product((int)$item['product_id'], $item['title'], (int)$item['price'], $item['image'], $item['description']);
        }
        return $result;
    }
}
