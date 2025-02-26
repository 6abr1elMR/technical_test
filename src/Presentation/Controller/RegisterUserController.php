<?php

namespace App\Presentation\Controller;

use App\Domain\UseCase\RegisterUserUseCase;
use App\Application\DTO\RegisterUserRequest;
use App\Domain\User\Exception\InvalidEmailException;
use App\Domain\User\Exception\WeakPasswordException;
use App\Domain\User\Exception\UserAlreadyExistsException;

class RegisterUserController
{
  private RegisterUserUseCase $registerUserUseCase;

  public function __construct(RegisterUserUseCase $registerUserUseCase)
  {
    $this->registerUserUseCase = $registerUserUseCase;
  }

  public function register(RegisterUserRequest $request): array
  {
    try {
      $response = $this->registerUserUseCase->execute($request);
      return [
        'status' => 'success',
        'data' => $response->toArray(),
      ];
    } catch (InvalidEmailException | WeakPasswordException | UserAlreadyExistsException $e) {
      return [
        'status' => 'error',
        'message' => $e->getMessage(),
      ];
    } catch (\Exception $e) {
      return [
        'status' => 'error',
        'message' => $e->getMessage(),
      ];
    }
  }
}
