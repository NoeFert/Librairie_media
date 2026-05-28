<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $emailAddresses = [
            'admin@example.com',
            'demo@example.com',
            'example@example.com'
        ];

        foreach ($emailAddresses as $i => $emailAddress){

            $isAdmin = ($i == 0);
            $user = new User();
            $user->setEmail($emailAddress);
            if($isAdmin){
                $user->setRoles(['ROLE_ADMIN']);
            }

            $password = '1234567';

            $user->setPassword(
                $this->userPasswordHasher->hashPassword($user, $password)
            );

            $manager->persist($user);
        }

        $manager->flush();
    }
}
