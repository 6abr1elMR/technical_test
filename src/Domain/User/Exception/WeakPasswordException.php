<?php

namespace App\Domain\User\Exception;

use Exception;

class WeakPasswordException extends Exception
{
  public function __construct()
  {
    parent::__construct("La contraseña no cumple con los requisitos de seguridad.");
  }
}
