<?php

namespace App\Service;

use App\DTO\StoreUserDTO;
use App\DTO\UpdateUserDTO;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function store(StoreUserDTO $userDTO): User
    {
        $user = new User(
            $userDTO->login,
            $userDTO->phone,
            $userDTO->password,
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function update(UpdateUserDTO $userDTO, User $user): User
    {
        foreach($userDTO as $key => $value) {
            $method = 'set' . ucfirst($key);

            if ($value !== null && method_exists($user, $method)) {
                $user->$method($value);
            }
        }

        $this->entityManager->flush();

        return $user;
    }

    public function delete(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    public function addRole(User $user, array $role): void
    {
        $user->setRoles($role);
        $this->entityManager->flush();
    }
}
