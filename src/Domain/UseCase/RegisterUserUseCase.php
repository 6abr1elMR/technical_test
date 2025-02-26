<?php

namespace App\Domain\UseCase;

use App\Domain\User\Entity\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\ValueObject\UserId;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Password;
use App\Domain\User\Event\UserRegisteredEvent;
use App\Domain\Event\EventDispatcher;
use App\Application\DTO\RegisterUserRequest;
use App\Application\DTO\UserResponseDTO;
use App\Domain\User\Exception\UserAlreadyExistsException;

class RegisterUserUseCase
{
  private UserRepositoryInterface $userRepository;
  private EventDispatcher $eventDispatcher;

  public function __construct(UserRepositoryInterface $userRepository, EventDispatcher $eventDispatcher)
  {
    $this->userRepository = $userRepository;
    $this->eventDispatcher = $eventDispatcher;
  }

  public function execute(RegisterUserRequest $request): UserResponseDTO
  {
    $email = new Email($request->getEmail());

    if ($this->userRepository->findByEmail($email)) {
      throw new UserAlreadyExistsException("El correo ya está registrado.");
    }

    $userId = new UserId(uniqid());
    $name = new Name($request->getName());
    $password = new Password($request->getPassword());

    $user = new User($userId, $name, $email, $password);
    $this->userRepository->save($user);

    $event = new UserRegisteredEvent($userId);
    $this->eventDispatcher->dispatch($event);

    return new UserResponseDTO(
      $userId->value(),
      $name->value(),
      $email->value(),
      $user->getCreatedAt()->format('Y-m-d H:i:s')
    );
  }
}
