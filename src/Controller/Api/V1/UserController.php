<?php

namespace App\Controller\Api\V1;

use App\DTO\UserDTO;
use App\Entity\User;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

class UserController extends AbstractController
{
    #[Route('/users', name: 'user_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    #[Route('/user', name: 'user_store', methods: ['POST'])]
    public function store(#[MapRequestPayload] UserDTO $userDTO, UserService $userService): JsonResponse
    {
        $user = $userService->store($userDTO);

        return $this->json([
            'id' => $user->getId(),
            'login' => $user->getLogin(),
            'phone' => $user->getPhone(),
            'password' => $user->getPassword(),
        ]);
    }

    #[Route('/user/{id}', name: 'user_show', methods: ['GET'])]
    public function show(User $user): JsonResponse
    {
        return $this->json([
            'login' => $user->getLogin(),
            'phone' => $user->getPhone(),
            'password' => $user->getPassword(),
        ]);
    }

    #[Route('/user/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function delete(User $user, UserService $userService): JsonResponse
    {
        $userService->delete($user);

        return $this->json([]);
    }
}
