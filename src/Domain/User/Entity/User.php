<?php

namespace App\Domain\User\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\User\ValueObject\UserId;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Password;
use DateTimeImmutable;

#[ORM\Entity]
#[ORM\Table(name: "users")]
final class User
{
  #[ORM\Id]
  #[ORM\Column(type: "string", length: 50)]
  private string $id;

  #[ORM\Column(type: "string", length: 255)]
  private string $name;

  #[ORM\Column(type: "string", length: 255, unique: true)]
  private string $email;

  #[ORM\Column(type: "string", length: 255)]
  private string $password;

  #[ORM\Column(type: "datetime_immutable")]
  private DateTimeImmutable $created_at;

  public function __construct(UserId $id, Name $name, Email $email, Password $password)
  {
    $this->id = $id->value();
    $this->name = $name->value();
    $this->email = $email->value();
    $this->password = $password->getHashedPassword();
    $this->created_at = new DateTimeImmutable();
  }

  public function getId(): string
  {
    return $this->id;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getEmail(): string
  {
    return $this->email;
  }

  public function getPassword(): string
  {
    return $this->password;
  }

  public function getCreatedAt(): DateTimeImmutable
  {
    return $this->created_at;
  }
}
