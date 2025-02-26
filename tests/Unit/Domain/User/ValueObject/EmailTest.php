<?php

namespace Tests\Unit\Domain\User\ValueObject;

use App\Domain\User\ValueObject\Email;
use App\Domain\User\Exception\InvalidEmailException;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
  public function testValidEmail()
  {
    $email = new Email('usuario@example.com');
    $this->assertEquals('usuario@example.com', $email->value());
  }

  public function testInvalidEmailThrowsException()
  {
    $this->expectException(InvalidEmailException::class);
    new Email('correo-invalido');
  }

  public function testEmptyEmailThrowsException()
  {
    $this->expectException(InvalidEmailException::class);
    new Email('');
  }
}
