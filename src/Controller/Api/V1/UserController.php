<?php

namespace App\Controller\Api\V1;

use App\DTO\StoreUserDTO;
use App\DTO\UpdateUserDTO;
use App\Entity\User;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController extends AbstractController
{
    #[Route('/api/v1/user', name: 'user_store', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function store(#[MapRequestPayload] StoreUserDTO $userDTO, UserService $userService): JsonResponse
    {
        $user = $userService->store($userDTO);

        return $this->json([
            'id' => $user->getId(),
            'login' => $user->getLogin(),
            'phone' => $user->getPhone(),
            'password' => $user->getPassword(),
        ]);
    }

    #[Route('/api/v1/user/{user}', name: 'user_update', methods: ['PUT'])]
    public function update(#[MapRequestPayload] UpdateUserDTO $userDTO, User $user, UserService $userService): JsonResponse
    {
        $this->denyAccessUnlessGranted('USER_UPDATE', $user);

        $user = $userService->update($userDTO, $user);

        return $this->json([
            'id' => $user->getId(),
        ]);
    }

    #[Route('/api/v1/user/{user}', name: 'user_show', methods: ['GET'])]
    public function show(User $user): JsonResponse
    {
        $this->denyAccessUnlessGranted('USER_SHOW', $user);

        return $this->json([
            'login' => $user->getLogin(),
            'phone' => $user->getPhone(),
            'password' => $user->getPassword(),
        ]);
    }

    #[Route('/api/v1/user/{user}', name: 'user_delete', methods: ['DELETE'])]
    public function delete(User $user, UserService $userService): JsonResponse
    {
        $this->denyAccessUnlessGranted('USER_DELETE', $user);

        $userService->delete($user);

        return $this->json([]);
    }
}
