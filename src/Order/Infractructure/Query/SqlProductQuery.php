<?php

namespace App\Order\Infractructure\Query;

use App\Order\Application\OrderProductsData;
use App\Order\Application\Query\ProductQuery;
use App\Order\Domain\Collection\ProductCollection;
use App\Order\Domain\ReadModel\Product;
use Doctrine\DBAL\Connection;

final class SqlProductQuery implements ProductQuery
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function getProducts(OrderProductsData $products): ProductCollection
    {
        $orderProducts = new ProductCollection();
        foreach ($products->getItems() as $productId => $quantity) {
            $record = $this->getProductById($productId);
            $product = new Product(
                productId: $record['product_id'],
                quantity: $quantity,
                price: $record['price'],
                title: $record['title']
            );
            $orderProducts->add($product);
        }
        return $orderProducts;
    }

    /**
     * @return array{product_id: int, title: string, price: int}
     */
    private function getProductById(int $productId): array
    {
        /** @var false|array{product_id: int, title: string, price: int} $record */
        $record = $this->connection->fetchAssociative(
            'SELECT product_id, title, price FROM product WHERE product_id = :product_id',
            ['product_id' => $productId]
        );

        if (empty($record)) {
            throw new \InvalidArgumentException('Product with id ' . $productId . ' is not found');
        }
        return $record;
    }
}
