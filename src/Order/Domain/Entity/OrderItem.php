<?php

namespace App\Order\Domain\Entity;

use App\Common\Domain\ValueObject\Money;
use App\Common\Domain\ValueObject\OrderId;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Embedded(class: OrderId::class)]
    #[ORM\Column]
    #[ORM\ManyToOne(targetEntity: Order::class, cascade: ['persist'], inversedBy: 'orderId')]
    private OrderId $orderId;

    #[ORM\Column]
    private int $productId;

    #[ORM\Column]
    private string $productTitle;

    #[ORM\Column]
    private int $quantity;

    #[ORM\Column]
    private int $price;

    public function __construct(OrderId $orderId, int $productId, int $quantity, Money $price, string $productTitle)
    {
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->price = $price->getAmount();
        $this->productTitle = $productTitle;
    }

    public function getPrice(): Money
    {
        return new Money($this->price);
    }
}
