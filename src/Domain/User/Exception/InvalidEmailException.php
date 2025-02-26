<?php

namespace App\Domain\User\Exception;

use Exception;

class InvalidEmailException extends Exception
{
  public function __construct()
  {
    parent::__construct("El formato del correo electrónico es inválido.");
  }
}
