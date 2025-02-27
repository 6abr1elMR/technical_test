<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

require_once __DIR__ . '/vendor/autoload.php';

$entityManager = (require 'bootstrap.php')['entityManager'];

ConsoleRunner::run(new SingleManagerProvider($entityManager));
