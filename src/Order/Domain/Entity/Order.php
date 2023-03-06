<?php

namespace App\Order\Domain\Entity;

use App\Common\Domain\ValueObject\Money;
use App\Order\Domain\Dto\OrderProduct;
use App\Order\Domain\ValueObject\Customer;
use App\Order\Domain\ValueObject\OrderId;
use App\Order\Domain\ValueObject\OrderStatus;
use App\Order\Domain\ValueObject\Phone;
use Webmozart\Assert\Assert;

final class Order
{
    private OrderId $orderId;
    private Customer $customer;
    private Phone $phone;
    public string $deliveryAddress;
    private OrderStatus $status;
    private Money $totalAmount;
    private array $orderItems = [];

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
