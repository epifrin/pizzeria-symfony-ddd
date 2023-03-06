<?php

namespace App\Order\Domain\Dto;

final class NewOrder
{
    /** @var non-empty-string */
    public string $firstname;
    /** @var non-empty-string */
    public string $lastname;
    /** @var non-empty-string */
    public string $phone;
    /** @var non-empty-string */
    public string $deliveryAddress;
}
