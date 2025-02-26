<?php

require_once __DIR__ . '/vendor/autoload.php';

$eventDispatcher = require __DIR__ . '/bootstrap.php';

use App\Infrastructure\Router;
use App\Infrastructure\Persistence\DoctrineUserRepository;
use App\Domain\UseCase\RegisterUserUseCase;
use App\Presentation\Controller\RegisterUserController;
use App\Application\DTO\RegisterUserRequest;
use App\Domain\Event\EventDispatcher;

$entityManager = (require 'bootstrap.php')['entityManager'];
$userRepository = new DoctrineUserRepository($entityManager);
$registerUserUseCase = new RegisterUserUseCase($userRepository, new EventDispatcher());
$registerUserController = new RegisterUserController($registerUserUseCase);

$router = new Router();

$router->addRoute('POST', '/register', function () use ($registerUserController) {
  $requestData = json_decode(file_get_contents('php://input'), true);

  if (!isset($requestData['name'], $requestData['email'], $requestData['password'])) {
    header("HTTP/1.0 400 Bad Request");
    echo json_encode(['error' => 'Datos incompletos']);
    return;
  }

  $request = new RegisterUserRequest(
    $requestData['name'],
    $requestData['email'],
    $requestData['password']
  );

  $response = $registerUserController->register($request);
  echo json_encode($response);
});

$router->addRoute('GET', '/', function () {
  echo 'Bienvenido a la aplicación';
});

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->dispatch($method, $uri);
