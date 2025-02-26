<?php

namespace Tests\Unit\Domain\User\ValueObject;

use App\Domain\User\ValueObject\UserId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class UserIdTest extends TestCase
{
  public function testValidUserId()
  {
    $userId = new UserId('unique-id-123');
    $this->assertEquals('unique-id-123', $userId->value());
  }

  public function testEmptyUserIdThrowsException()
  {
    $this->expectException(InvalidArgumentException::class);
    new UserId('');
  }
}
