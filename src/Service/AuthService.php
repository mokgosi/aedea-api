<?php

namespace App\Service;

use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class AuthService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly JWTTokenManagerInterface $jwtManager
    ) {
    }

    public function authenticate(string $email, string $password): ?array
    {
        $user = $this->userRepository->findOneBy([
            'email' => $email,
        ]);

        if (!$user) {
            return null;
        }

        $isValid = $this->passwordHasher->isPasswordValid(
            $user,
            $password
        );

        if (!$isValid) {
            return null;
        }

        /*
         |--------------------------------------------------------------------------
         | Generate JWT Token
         |--------------------------------------------------------------------------
        */

        // $token = base64_encode(random_bytes(32));
        $token = $this->jwtManager->create($user);

        return [
            'token' => $token,
            'user' => $user,
        ];
    }
}