<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;

use App\Dto\RegisterUserInput;
use App\Entity\User;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterUserProcessor
    implements ProcessorInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): mixed {

        /*
         |--------------------------------------------------------------------------
         | Create User
         |--------------------------------------------------------------------------
         */

        $user = new User();

        $user->setEmail(
            strtolower($data->email)
        );

        $user->setRoles([
            'ROLE_USER'
        ]);

        $hashedPassword =
            $this->passwordHasher
                ->hashPassword(
                    $user,
                    $data->password
                );

        $user->setPassword(
            $hashedPassword
        );

        $this->entityManager
            ->persist($user);

        $this->entityManager
            ->flush();

        return $user;
    }
}