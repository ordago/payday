<?php

namespace App\ValueObjects;

class Money
{
    public function __construct(private readonly int $valueInCents)
    {
    }

    public static function from(int $valueInCents): self
    {
        return new static($valueInCents);
    }

    public function toDollars(): string
    {
        return '$' . number_format($this->valueInCents / 100, 2);
    }

    public function toCents(): int
    {
        return $this->valueInCents;
    }
}
