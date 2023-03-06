<?php

namespace App\Order\Domain\Collection;

use App\Common\Domain\ValueObject\Money;
use App\Order\Domain\Dto\OrderProduct;
use Traversable;

/**
 * @implements \IteratorAggregate<int, OrderProduct>
 */
final class OrderProductCollection implements \IteratorAggregate
{
    /** @var OrderProduct[] */
    private array $products = [];
    private Money $total;

    public function __construct()
    {
        $this->total = new Money(0);
    }

    public function add(OrderProduct $product): void
    {
        $this->products[] = $product;
        $this->total = $this->total->add($product->price->multiply($product->quantity));
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
