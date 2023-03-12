<?php

namespace App\Delivery\Domain\Entity;

use App\Common\Domain\ValueObject\OrderId;
use App\Delivery\Domain\Repository\DeliveryRepository;
use App\Delivery\Domain\ValueObject\DeliveryStatus;
use App\Common\Domain\ValueObject\Customer;
use App\Common\Domain\ValueObject\Phone;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Entity(repositoryClass: DeliveryRepository::class)]  /* @phpstan-ignore-line */
class Delivery
{
    #[ORM\Id]
    #[ORM\GeneratedValue('SEQUENCE')]
    private int $id;

    #[ORM\Embedded(class: OrderId::class, columnPrefix: false)]
    private OrderId $orderId;

    #[ORM\Embedded(class: Customer::class, columnPrefix: false)]
    private Customer $customer;

    #[ORM\Embedded(class: Phone::class, columnPrefix: false)]
    private Phone $phone;

    #[ORM\Column(length: 255)]
    private string $deliveryAddress;

    #[ORM\Column(length: 255)]
    private string $deliveryMan;

    #[ORM\Column(type: "integer", enumType: DeliveryStatus::class)]
    private DeliveryStatus $status;

    #[ORM\Column(type: "datetime_immutable", nullable: true)]
    private \DateTimeImmutable $deliveredAt;

    /**
     * @param-phpstan non-empty-string $address
     */
    public static function create(OrderId $orderId, Customer $customer, Phone $phone, string $address): self
    {
        $entity = new self();
        $entity->orderId = $orderId;
        $entity->customer = $customer;
        $entity->phone = $phone;
        Assert::notEmpty($address);
        $entity->deliveryAddress = $address;
        $entity->status = DeliveryStatus::NEW;
        return $entity;
    }

    public function setDeliveryMan(string $deliveryMan): void
    {
        $this->deliveryMan = $deliveryMan;
    }

    public function setStatusInProgress()
    {
        $this->status = DeliveryStatus::IN_PROGRESS;
    }

    public function isStatusNew(): bool
    {
        return $this->status === DeliveryStatus::NEW;
    }

    public function isStatusInProgress(): bool
    {
        return $this->status === DeliveryStatus::IN_PROGRESS;
    }
}
