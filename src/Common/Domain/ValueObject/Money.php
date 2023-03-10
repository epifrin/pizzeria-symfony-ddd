<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;

/** @immutable */
#[ORM\Embeddable]
final class Money
{
    #[ORM\Column(type: "integer", name: "total_amount")]
    private int $amount;

    private string $currency;

    public function __construct(int $amount, string $currency = 'USD')
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getNormalizedAmount(): string
    {
        return (string)($this->amount / 100);
    }

    public function getUSD(): string
    {
        return '$' . $this->getNormalizedAmount();
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function add(Money $money): Money
    {
        if ($this->currency !== $money->currency) {
            throw new \InvalidArgumentException('Currencies do not match.');
        }

        return new Money($this->amount + $money->amount, $this->currency);
    }

    public function multiply(int $quantity): Money
    {
        return new Money($this->amount * $quantity, $this->currency);
    }

    public function subtract(Money $money): Money
    {
        if ($this->currency !== $money->currency) {
            throw new \InvalidArgumentException('Currencies do not match.');
        }

        return new Money($this->amount - $money->amount, $this->currency);
    }

    public function equals(Money $money): bool
    {
        return $this->amount === $money->amount && $this->currency === $money->currency;
    }
}
