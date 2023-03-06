<?php

namespace App\Product\Domain\ViewModel;

use App\Common\Domain\ValueObject\Money;

final class Product
{
    public int $productId;
    public string $title;
    public Money $price;
    public string $image;
    public string $description;

    public function __construct(int $productId, string $title, int $price, string $image, string $description)
    {
        $this->productId = $productId;
        $this->title = $title;
        $this->price = new Money($price);
        $this->image = $image;
        $this->description = $description;
    }
}
