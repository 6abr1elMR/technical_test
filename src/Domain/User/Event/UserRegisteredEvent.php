<?php

namespace App\Domain\User\Event;

use App\Domain\User\ValueObject\UserId;

final class UserRegisteredEvent
{
    public const NAME = 'user.registered';

    private UserId $userId;

    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }
}
