<?php

namespace App\Domain\User\ValueObject;

final class Name
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);

        if (empty($value)) {
            throw new \InvalidArgumentException("Name cannot be empty.");
        }

        if (strlen($value) < 2 || strlen($value) > 100) {
            throw new \InvalidArgumentException("Name must be between 2 and 100 characters.");
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
