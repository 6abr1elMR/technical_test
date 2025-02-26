<?php

namespace App\Domain\User\ValueObject;

use App\Domain\User\Exception\InvalidEmailException;

class Email
{
    private string $value;

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException();
        }

        $this->value = $email;
    }

    public function value(): string
    {
        return $this->value;
    }
}
