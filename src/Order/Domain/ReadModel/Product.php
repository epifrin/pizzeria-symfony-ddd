<?php

namespace App\Order\Domain\ReadModel;

use App\Common\Domain\ValueObject\Money;

class Product
{
    private int $productId;
    private int $quantity;
    private Money $price;
    private Money $total;
    private string $title;
    public function __construct(int $productId, int $quantity, int $price, string $title)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->price = new Money($price);
        $this->total = $this->price->multiply($this->quantity);
        $this->title = $title;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): Money
    {
        return $this->price;
    }

    public function getTotal(): Money
    {
        return $this->total;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
