<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    private Generator $fakerFactory;

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
        $this->fakerFactory = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {

        // CREATE FAKE USERS
        foreach (AppFixtures::USERS_ROLE_TYPES as $userRoleType) {

            for ($x = 0; $x < AppFixtures::USERS_COUNT; $x++) {

                $myUser = new User();

                // Prepare Data
                $fakerUserPassword = (AppFixtures::USER_GENERATE_RANDOM_PASSWORD !== TRUE) ? AppFixtures::USER_GENERATE_RANDOM_PASSWORD : $this->fakerFactory->password(8, 12);
                $userPassword = AppFixtures::USER_SKIP_HASH_PASSWORDS === TRUE ? $fakerUserPassword : $this->passwordHasher->hashPassword($myUser, $fakerUserPassword);

                $accountName = $this->fakerFactory->firstName . " " . $this->fakerFactory->lastName;
                $nickName = $this->fakerFactory->userName;

                // Set Data
                $myUser->setEmail($this->fakerFactory->email);
                $myUser->setPassword($userPassword);
                $myUser->setRoles([$userRoleType]);
                $myUser->setAccountname($accountName);
                $myUser->setNickname($nickName);

                // And Persist
                $manager->persist($myUser);

            }

        }


        $manager->flush();

    }
}
