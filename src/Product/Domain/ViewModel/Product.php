<?php

namespace App\Product\Domain\ViewModel;

final class Product
{
    public int $productId;
    public string $title;
    public string $image;
    public string $description;

    public function __construct(int $productId, string $title, string $image, string $description)
    {
        $this->productId = $productId;
        $this->title = $title;
        $this->image = $image;
        $this->description = $description;
    }
}
