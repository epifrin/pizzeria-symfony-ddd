<?php

namespace App\Order\Domain\Entity;

use App\Common\Domain\ValueObject\Money;
use App\Order\Domain\ReadModel\Product;
use App\Order\Domain\Repository\OrderRepository;
use App\Common\Domain\ValueObject\Customer;
use App\Common\Domain\ValueObject\OrderId;
use App\Order\Domain\ValueObject\OrderStatus;
use App\Common\Domain\ValueObject\Phone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Entity(repositoryClass: OrderRepository::class)]  /* @phpstan-ignore-line */
#[ORM\Table(name: "public.order")]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Embedded(class: OrderId::class, columnPrefix: false)]
    private OrderId $orderId;

    #[ORM\Embedded(class: Customer::class, columnPrefix: false)]
    private Customer $customer;

    #[ORM\Embedded(class: Phone::class, columnPrefix: false)]
    private Phone $phone;

    #[ORM\Column(length: 255)]
    private string $deliveryAddress;

    #[ORM\Column(type: "integer", enumType: OrderStatus::class)]
    private OrderStatus $status;

    #[ORM\Embedded(class: Money::class, columnPrefix: false)]
    private Money $totalAmount;

    #[ORM\Column(type: "datetime_immutable", nullable: true)]
    private \DateTimeImmutable $updatedAt;

    /**
     * @phpstan-var ArrayCollection<int, OrderItem>
     */
    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'orderId', cascade: ['persist'])]
    private Collection $orderItems;

    public function __construct(OrderId $orderId, Customer $customer, Phone $phone, string $address, OrderStatus $status)
    {
        $this->orderId = $orderId;
        $this->customer = $customer;
        $this->phone = $phone;
        Assert::notEmpty($address);
        $this->deliveryAddress = $address;
        $this->status = $status;
        $this->totalAmount = new Money(0);
        $this->orderItems = new ArrayCollection();
    }

    public function addItem(Product $product): void
    {
        $this->orderItems[] = new OrderItem($this->orderId, $product->getProductId(), $product->getQuantity(), $product->getPrice(), $product->getTitle());
        $this->totalAmount = $this->totalAmount->add($product->getTotal());
    }

    public function getOrderId(): OrderId
    {
        return $this->orderId;
    }

    public function getTotalAmount(): Money
    {
        return $this->totalAmount;
    }

    public function setPrepared(): void
    {
        $this->status = OrderStatus::PREPARED;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function setDelivered(): void
    {
        $this->status = OrderStatus::DELIVERED;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function setCancel(): void
    {
        $this->status = OrderStatus::CANCELLED;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function getDeliveryAddress(): string
    {
        return $this->deliveryAddress;
    }

    public function isPrepared(): bool
    {
        return $this->status === OrderStatus::PREPARED;
    }
}
