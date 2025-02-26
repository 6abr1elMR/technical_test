<?php

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Persistence\DoctrineUserRepository;
use App\Domain\User\Entity\User;
use App\Domain\User\ValueObject\UserId;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Password;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineUserRepositoryTest extends TestCase
{
  private $entityManager;
  private $repository;
  private $doctrineUserRepository;

  protected function setUp(): void
  {
    $this->entityManager = $this->createMock(EntityManagerInterface::class);

    $this->repository = $this->createMock(EntityRepository::class);

    $this->entityManager
      ->method('getRepository')
      ->willReturn($this->repository);

    $this->doctrineUserRepository = new DoctrineUserRepository($this->entityManager);
  }

  public function testSave(): void
  {
    $userId = new UserId(uniqid());
    $name = new Name('Juan');
    $email = new Email('test@example.com');
    $password = new Password('SecurePassword123*');
    $user = new User($userId, $name, $email, $password);

    $this->entityManager
      ->expects($this->once())
      ->method('persist')
      ->with($user);

    $this->entityManager
      ->expects($this->once())
      ->method('flush');

    $this->doctrineUserRepository->save($user);
  }

  public function testFindById(): void
  {
    $userId = new UserId(uniqid());
    $name = new Name('Juan');
    $email = new Email('test@example.com');
    $password = new Password('SecurePassword123*');
    $user = new User($userId, $name, $email, $password);

    $this->repository
      ->expects($this->once())
      ->method('find')
      ->with($userId->value())
      ->willReturn($user);

    $foundUser = $this->doctrineUserRepository->findById($userId);

    $this->assertSame($user, $foundUser);
  }

  public function testFindByEmail(): void
  {
    $userId = new UserId(uniqid());
    $name = new Name('Juan');
    $email = new Email('test@example.com');
    $password = new Password('SecurePassword123*');
    $user = new User($userId, $name, $email, $password);

    $this->repository
      ->expects($this->once())
      ->method('findOneBy')
      ->with(['email' => $email->value()])
      ->willReturn($user);

    $foundUser = $this->doctrineUserRepository->findByEmail($email);

    $this->assertSame($user, $foundUser);
  }

  public function testDelete(): void
  {
    $userId = new UserId(uniqid());
    $name = new Name('Juan');
    $email = new Email('test@example.com');
    $password = new Password('SecurePassword123*');
    $user = new User($userId, $name, $email, $password);

    $this->repository
      ->method('find')
      ->with($userId->value())
      ->willReturn($user);

    $this->entityManager
      ->expects($this->once())
      ->method('remove')
      ->with($user);

    $this->entityManager
      ->expects($this->once())
      ->method('flush');

    $this->doctrineUserRepository->delete($userId);
  }
}
