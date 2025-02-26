<?php

namespace App\Domain\User\ValueObject;

final class UserId
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException("User ID cannot be empty.");
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
