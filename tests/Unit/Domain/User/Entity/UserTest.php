<?php

namespace Tests\Domain\User\Entity;

use PHPUnit\Framework\TestCase;
use App\Domain\User\Entity\User;
use App\Domain\User\ValueObject\UserId;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Password;

class UserTest extends TestCase
{
  public function testUserCreation()
  {
    $userId = new UserId(uniqid());
    $name = new Name('Juan');
    $email = new Email('juan@example.com');
    $password = new Password('SecurePassword123*');

    $user = new User($userId, $name, $email, $password);

    $this->assertEquals($userId->value(), $user->getId());
    $this->assertEquals($name->value(), $user->getName());
    $this->assertEquals($email->value(), $user->getEmail());
    $this->assertEquals($password->getHashedPassword(), $user->getPassword());
  }
}
