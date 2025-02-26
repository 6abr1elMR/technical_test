<?php

namespace Tests\Unit\Domain\User\ValueObject;

use App\Domain\User\ValueObject\Name;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
  public function testValidName()
  {
    $name = new Name('Juan Pérez');
    $this->assertEquals('Juan Pérez', $name->value());
  }

  public function testEmptyNameThrowsException()
  {
    $this->expectException(InvalidArgumentException::class);
    new Name('');
  }

  public function testWhitespaceOnlyNameThrowsException()
  {
    $this->expectException(InvalidArgumentException::class);
    new Name('   ');
  }

  public function testShortNameThrowsException()
  {
    $this->expectException(InvalidArgumentException::class);
    new Name('A');
  }

  public function testLongNameThrowsException()
  {
    $this->expectException(InvalidArgumentException::class);
    new Name(str_repeat('a', 101));
  }
}
