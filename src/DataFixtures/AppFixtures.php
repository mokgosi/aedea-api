<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\User;
use App\Factory\ContactFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {

    }

    public function load(ObjectManager $manager): void
    {
        
        UserFactory::createOne([
            'email' => 'admin@mail.com',
            'password' => 'password',
            'roles' => ['ROLE_ADMIN'],
        ]);

        ContactFactory::createMany(10);
    }
}
