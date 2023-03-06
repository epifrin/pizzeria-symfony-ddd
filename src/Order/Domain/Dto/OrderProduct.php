<?php

namespace App\Order\Domain\Dto;

use App\Common\Domain\ValueObject\Money;

final class OrderProduct
{
    public int $productId;
    public int $quantity;
    public Money $price;
    public Money $total;
    public string $title;

    /**
     * @param array{'product_id': int, 'price': int, 'title': string} $record
     * @param-phpstan non-empty-array{'product_id': int, 'price': int, 'title': string} $record
     * @return self
     */
    public static function loadFromDb(array $record): self
    {
        $dto = new self();
        $dto->productId = (int)$record['product_id'];
        $dto->price = new Money((int)$record['price']);
        $dto->title = $record['title'];
        return $dto;
    }

    public function setQuantityAndTotal(int $quantity): void
    {
        $this->quantity = $quantity;
        $this->total = $this->price->multiply($this->quantity);
    }
}
