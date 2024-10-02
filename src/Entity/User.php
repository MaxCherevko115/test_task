<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 8)]
    #[Assert\Unique]
    #[Assert\Length(
          max: 8,
          maxMessage: "Login cannot be longer than {{ limit }} characters"
     )]
    private string $login;

    #[ORM\Column(type: "string", length: 8)]
    #[Assert\Length(
         max: 8,
         maxMessage: "Phone cannot be longer than {{ limit }} characters"
    )]
    private string $phone;

    #[ORM\Column(type: "string", length: 8)]
    #[Assert\Unique]
    #[Assert\Length(
        max: 8,
        maxMessage: "Password cannot be longer than {{ limit }} characters"
    )]
    private string $password;

    public function __construct(string $login, string $phone, string $password)
    {
        $this->setLogin($login);
        $this->setPhone($phone);
        $this->setPassword($password);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}
