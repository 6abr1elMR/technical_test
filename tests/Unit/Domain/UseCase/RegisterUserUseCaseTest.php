<?php

namespace Tests\Unit\Domain\UseCase;

use PHPUnit\Framework\TestCase;
use App\Domain\UseCase\RegisterUserUseCase;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\Event\EventDispatcher;
use App\Application\DTO\RegisterUserRequest;
use App\Application\DTO\UserResponseDTO;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\Entity\User;
use App\Domain\User\ValueObject\UserId;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Password;
use App\Domain\User\Exception\UserAlreadyExistsException;
use App\Domain\User\Event\UserRegisteredEvent;

class RegisterUserUseCaseTest extends TestCase
{
  private $userRepository;
  private $eventDispatcher;
  private $useCase;

  protected function setUp(): void
  {
    $this->userRepository = $this->createMock(UserRepositoryInterface::class);

    $this->eventDispatcher = $this->createMock(EventDispatcher::class);

    $this->useCase = new RegisterUserUseCase($this->userRepository, $this->eventDispatcher);
  }

  public function testRegisterUserSuccessfully(): void
  {
    $request = new RegisterUserRequest('Juan', 'test@example.com', 'SecurePassword123*');
    $email = new Email($request->getEmail());
    $userId = new UserId(uniqid());
    $name = new Name($request->getName());
    $password = new Password($request->getPassword());
    $user = new User($userId, $name, $email, $password);

    $this->userRepository
      ->method('findByEmail')
      ->with($email)
      ->willReturn(null);

    $this->userRepository
      ->expects($this->once())
      ->method('save')
      ->with($this->isInstanceOf(User::class));

    $this->eventDispatcher
      ->expects($this->once())
      ->method('dispatch')
      ->with($this->isInstanceOf(UserRegisteredEvent::class));

    $response = $this->useCase->execute($request);

    $this->assertInstanceOf(UserResponseDTO::class, $response);
    $this->assertEquals($name->value(), $response->getName());
    $this->assertEquals($email->value(), $response->getEmail());
  }

  public function testRegisterUserFailsWhenEmailAlreadyExists(): void
  {
    $request = new RegisterUserRequest('Juan', 'test@example.com', 'SecurePassword123*');
    $email = new Email($request->getEmail());

    $this->userRepository
      ->method('findByEmail')
      ->with($email)
      ->willReturn(new User(new UserId(uniqid()), new Name('Juan'), $email, new Password('SecurePassword123*')));

    $this->expectException(UserAlreadyExistsException::class);
    $this->expectExceptionMessage("El usuario con este email ya está registrado.");

    $this->useCase->execute($request);
  }
}
