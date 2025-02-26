<?php

namespace App\Domain\User\Exception;

use Exception;

class UserAlreadyExistsException extends Exception
{
  public function __construct()
  {
    parent::__construct("El usuario con este email ya está registrado.");
  }
}
