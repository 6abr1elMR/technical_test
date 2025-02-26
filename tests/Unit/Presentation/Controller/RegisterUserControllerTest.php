<?php

namespace Tests\Unit\Presentation\Controller;

use PHPUnit\Framework\TestCase;
use App\Presentation\Controller\RegisterUserController;
use App\Domain\UseCase\RegisterUserUseCase;
use App\Application\DTO\RegisterUserRequest;
use App\Application\DTO\UserResponseDTO;
use App\Domain\User\Exception\InvalidEmailException;
use App\Domain\User\Exception\WeakPasswordException;
use App\Domain\User\Exception\UserAlreadyExistsException;

class RegisterUserControllerTest extends TestCase
{
  private $registerUserUseCase;
  private $controller;

  protected function setUp(): void
  {
    $this->registerUserUseCase = $this->createMock(RegisterUserUseCase::class);

    $this->controller = new RegisterUserController($this->registerUserUseCase);
  }

  public function testRegisterUserSuccessfully(): void
  {
    $request = new RegisterUserRequest('Juan', 'test@example.com', 'SecurePassword123*');

    $userResponseDTO = new UserResponseDTO('12345', 'Juan', 'test@example.com', '2024-02-24 12:00:00');

    $this->registerUserUseCase
      ->method('execute')
      ->with($request)
      ->willReturn($userResponseDTO);

    $response = $this->controller->register($request);

    $this->assertEquals('success', $response['status']);
    $this->assertEquals($userResponseDTO->toArray(), $response['data']);
  }

  public function testRegisterUserFailsWithUserAlreadyExistsException(): void
  {
    $request = new RegisterUserRequest('Juan', 'test@example.com', 'SecurePassword123*');

    $this->registerUserUseCase
      ->method('execute')
      ->with($request)
      ->willThrowException(new UserAlreadyExistsException("El usuario con este email ya está registrado."));

    $response = $this->controller->register($request);

    $this->assertEquals('error', $response['status']);
    $this->assertEquals("El usuario con este email ya está registrado.", $response['message']);
  }

  public function testRegisterUserFailsWithInvalidEmailException(): void
  {
    $request = new RegisterUserRequest('Juan', 'invalid-email', 'SecurePassword123*');

    $this->registerUserUseCase
      ->method('execute')
      ->with($request)
      ->willThrowException(new InvalidEmailException("El formato del correo electrónico es inválido."));

    $response = $this->controller->register($request);

    $this->assertEquals('error', $response['status']);
    $this->assertEquals("El formato del correo electrónico es inválido.", $response['message']);
  }

  public function testRegisterUserFailsWithWeakPasswordException(): void
  {
    $request = new RegisterUserRequest('Juan', 'test@example.com', '123');

    $this->registerUserUseCase
      ->method('execute')
      ->with($request)
      ->willThrowException(new WeakPasswordException("La contraseña no cumple con los requisitos de seguridad."));

    $response = $this->controller->register($request);

    $this->assertEquals('error', $response['status']);
    $this->assertEquals("La contraseña no cumple con los requisitos de seguridad.", $response['message']);
  }

  public function testRegisterUserFailsWithGeneralException(): void
  {
    $request = new RegisterUserRequest('Juan', 'test@example.com', 'SecurePassword123*');

    $this->registerUserUseCase
      ->method('execute')
      ->with($request)
      ->willThrowException(new \Exception("Error inesperado en el sistema."));

    $response = $this->controller->register($request);

    $this->assertEquals('error', $response['status']);
    $this->assertEquals("Error inesperado en el sistema.", $response['message']);
  }
}
