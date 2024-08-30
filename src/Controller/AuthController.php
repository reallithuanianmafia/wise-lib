<?php

// src/Controller/AuthController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    #[Route('/api/check-auth', name: 'check_auth', methods: ['GET'])]
    public function checkAuth(): JsonResponse
    {
        if ($this->isGranted('ROLE_USER')) {
            // Return user details if authenticated
            $user = $this->getUser();
            return new JsonResponse([
                'authenticated' => true,
                'userName' => $user->getUsername() // Assuming you use getUsername() for the username
            ]);
        }

        return new JsonResponse(['authenticated' => false], 401);
    }
}
