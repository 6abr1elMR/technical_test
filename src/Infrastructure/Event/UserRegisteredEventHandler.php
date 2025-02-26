<?php

namespace App\Infrastructure\Event;

use App\Domain\User\Event\UserRegisteredEvent;

class UserRegisteredEventHandler
{
    public function __invoke(UserRegisteredEvent $event): void
    {
        echo "Welcome email sent to user with ID: " . $event->userId()->value() . "\n";
    }
}
