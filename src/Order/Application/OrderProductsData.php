<?php

namespace App\Order\Application;

use Webmozart\Assert\Assert;

class OrderProductsData
{
    /** @var array<int, int> */
    private array $items = [];

    /**
     * @param mixed $data
     */
    public function __construct(mixed $data)
    {
        Assert::notEmpty($data);
        Assert::isArray($data);
        foreach ($data as $productId => $quantity) {
            Assert::notEmpty($productId);
            Assert::numeric($productId);
            $productId = (int)$productId;
            Assert::notEmpty($quantity);
            Assert::numeric($quantity);
            $quantity = (int)$quantity;
            Assert::greaterThan($quantity, 0);
            $this->items[$productId] = $quantity;
        }
    }

    /**
     * @return array<int, int>
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
