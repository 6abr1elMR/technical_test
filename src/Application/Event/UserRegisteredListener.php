<?php

namespace App\Application\EventListener;

use App\Domain\User\Event\UserRegisteredEvent;

class UserRegisteredListener
{
  public function handle(UserRegisteredEvent $event): void
  {
    echo "📩 Email enviado al usuario con ID: " . $event->userId()->value() . "\n";
  }
}
