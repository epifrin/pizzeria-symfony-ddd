<?php

declare(strict_types=1);

namespace App\Order\Domain\Service;

use App\Order\Domain\Collection\OrderProductCollection;
use App\Order\Domain\Query\ProductQuery;
use Webmozart\Assert\Assert;

final class OrderProductsService
{
    public function __construct(
        private readonly ProductQuery $productQuery
    ) {
    }

    /**
     * @param array<int, int> $products
     * @return OrderProductCollection
     */
    public function getProducts(array $products): OrderProductCollection
    {
        Assert::notEmpty($products);
        $orderProducts = new OrderProductCollection();
        foreach ($products as $productId => $quantity) {
            Assert::notEmpty($productId);
            Assert::notEmpty($quantity);
            Assert::numeric($quantity);
            $quantity = (int)$quantity;
            Assert::greaterThan($quantity, 0);

            $product = $this->productQuery->getProductById($productId);
            $product->setQuantityAndTotal($quantity);
            $orderProducts->add($product);
        }
        return $orderProducts;
    }
}
