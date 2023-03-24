<?php

namespace App\Order\Domain\Collection;

use App\Common\Domain\ValueObject\Money;
use App\Order\Domain\ReadModel\Product;
use Traversable;

/**
 * @implements \IteratorAggregate<int, Product>
 */
final class ProductCollection implements \IteratorAggregate
{
    /** @var Product[] */
    private array $products = [];
    private Money $total;

    public function __construct()
    {
        $this->total = new Money(0);
    }

    public function add(Product $product): void
    {
        $this->products[] = $product;
        $this->total = $this->total->add($product->getPrice()->multiply($product->getQuantity()));
    }

    public function getTotal(): Money
    {
        return $this->total;
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->products);
    }
}
