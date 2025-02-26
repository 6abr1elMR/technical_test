<?php

use App\Infrastructure\Doctrine\EntityManagerFactory;
use App\Domain\Event\EventDispatcher;
use App\Domain\User\Event\UserRegisteredEvent;


$entityManager = EntityManagerFactory::create();

$eventDispatcher = new EventDispatcher();

$eventDispatcher->addListener(UserRegisteredEvent::class, function ($event) {
    $logDir = __DIR__ . '/logs';
    $logFile = $logDir . '/emails.log';

    if (!is_dir($logDir)) {
        mkdir($logDir, 0777, true);
    }

    file_put_contents(
        $logFile,
        "[" . date('Y-m-d H:i:s') . "] Se enviaría un correo a usuario con ID " .
            $event->userId()->value() . PHP_EOL,
        FILE_APPEND
    );
});

return [
    'entityManager'   => $entityManager,
    'eventDispatcher' => $eventDispatcher,
];
