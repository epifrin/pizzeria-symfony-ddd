<?php

namespace App\Order\Domain\ValueObject;

use Ramsey\Uuid\UuidInterface;

/** @immutable */
final class OrderId
{
    private UuidInterface $id;

    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    public function __toString(): string
    {
        return $this->id->toString();
    }
}
