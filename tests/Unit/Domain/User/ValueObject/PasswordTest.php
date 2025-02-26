<?php

namespace Tests\Unit\Domain\User\ValueObject;

use App\Domain\User\ValueObject\Password;
use App\Domain\User\Exception\WeakPasswordException;
use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase
{
  public function testValidPasswordIsHashed()
  {
    $password = new Password('StrongPass1!');
    $this->assertNotEquals('StrongPass1!', $password->getHashedPassword());
    $this->assertTrue(password_verify('StrongPass1!', $password->getHashedPassword()));
  }

  public function testPasswordWithoutUppercaseThrowsException()
  {
    $this->expectException(WeakPasswordException::class);
    new Password('weakpass1!');
  }

  public function testPasswordWithoutNumberThrowsException()
  {
    $this->expectException(WeakPasswordException::class);
    new Password('WeakPass!');
  }

  public function testPasswordWithoutSpecialCharacterThrowsException()
  {
    $this->expectException(WeakPasswordException::class);
    new Password('WeakPass1');
  }

  public function testShortPasswordThrowsException()
  {
    $this->expectException(WeakPasswordException::class);
    new Password('Wp1!');
  }
}
