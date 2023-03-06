<?php

namespace App\Order\Domain\Entity;

use App\Common\Domain\ValueObject\Money;
use App\Order\Domain\Dto\OrderProduct;
use App\Order\Domain\Repository\OrderRepository;
use App\Order\Domain\ValueObject\Customer;
use App\Order\Domain\ValueObject\OrderId;
use App\Order\Domain\ValueObject\OrderStatus;
use App\Order\Domain\ValueObject\Phone;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: "public.order")]
final class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Column]
    #[ORM\Embedded(class: OrderId::class)]
    private OrderId $orderId;

    #[ORM\Embedded(class: Customer::class, columnPrefix: false)]
    private Customer $customer;

    #[ORM\Embedded(class: Phone::class, columnPrefix: false)]
    private Phone $phone;

    #[ORM\Column(length: 255)]
    public string $deliveryAddress;

    #[ORM\Column(type: "integer", enumType: OrderStatus::class)]
    private OrderStatus $status;

    #[ORM\Embedded(class: Money::class, columnPrefix: false)]
    private Money $totalAmount;

    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'orderId', cascade: ['persist'])]
    private $orderItems;

    public function __construct(OrderId $orderId, Customer $customer, Phone $phone, string $address, OrderStatus $status)
    {
        $this->orderId = $orderId;
        $this->customer = $customer;
        $this->phone = $phone;
        Assert::notEmpty($address);
        $this->deliveryAddress = $address;
        $this->status = $status;
        $this->totalAmount = new Money(0);
    }

    public function addItem(OrderProduct $product)
    {
        $this->orderItems[] = new OrderItem($this->orderId, $product->productId, $product->quantity, $product->price, $product->title);
        $this->totalAmount = $this->totalAmount->add($product->total);
    }
}
