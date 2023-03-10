<?php

namespace App\Order\Infractructure\Query;

use App\Order\Domain\Dto\OrderProduct;
use App\Order\Domain\Query\ProductQuery;
use Doctrine\DBAL\Connection;

final class SqlProductQuery implements ProductQuery
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function getById(int $productId): OrderProduct
    {
        /** @var false|array{product_id: int, title: string, price: int} $record */
        $record = $this->connection->fetchAssociative(
            'SELECT product_id, title, price FROM product WHERE product_id = :product_id',
            ['product_id' => $productId]
        );

        if (empty($record)) {
            throw new \InvalidArgumentException('Product with id ' . $productId . ' is not found');
        }
        return OrderProduct::loadFromDb($record);
    }
}
