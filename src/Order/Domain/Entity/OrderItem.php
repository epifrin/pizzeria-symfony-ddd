<?php

namespace App\Order\Domain\Entity;

use App\Common\Domain\ValueObject\Money;
use App\Order\Domain\ValueObject\OrderId;

final class OrderItem
{
    private OrderId $orderId;
    private int $productId;
    private string $productTitle;
    private int $quantity;
    private Money $price;
    private Money $totalAmount;

    public function __construct(OrderId $orderId, int $productId, int $quantity, Money $price, string $productTitle)
    {
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->totalAmount = new Money($price->getAmount() * $this->quantity);
        $this->productTitle = $productTitle;
    }

    public function getTotalAmount(): Money
    {
        return $this->totalAmount;
    }
}
