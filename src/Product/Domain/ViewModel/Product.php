<?php

namespace App\Product\Domain\ViewModel;

class Product
{
    public int $productId;
    // category ?
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
