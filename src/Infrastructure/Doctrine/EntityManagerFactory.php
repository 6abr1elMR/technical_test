<?php

namespace App\Infrastructure\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;

class EntityManagerFactory
{
  public static function create(): EntityManager
  {
    $config = ORMSetup::createAttributeMetadataConfiguration(
      paths: [__DIR__ . '/../../Domain/User/Entity'],
      isDevMode: true
    );

    $connection = DriverManager::getConnection([
      'dbname'   => 'mydblocal',
      'user'     => 'user_db',
      'password' => 'pass1234',
      'host'     => 'mysql',
      'port'     => 3306,
      'driver'   => 'pdo_mysql',
      'charset'  => 'utf8mb4',
    ], $config);

    return new EntityManager($connection, $config);
  }
}
