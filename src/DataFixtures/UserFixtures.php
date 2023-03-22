<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{

    private Generator $fakerFactory;

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
        $this->fakerFactory = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {

        // Persist Fake Users
        for ($x = 0; $x < AppFixtures::USERS_COUNT; $x++) {

            $fakeUser = new User();

            $fakeUser->setEmail($this->fakerFactory->email);
            $fakeUser->setPassword($this->passwordHasher->hashPassword($fakeUser, $this->fakerFactory->password(8, 12)));
            $fakeUser->setAccountname($this->fakerFactory->firstName . " " . $this->fakerFactory->lastName);
            $fakeUser->setNickname($this->fakerFactory->userName);
            $fakeUser->setRoles(["ROLE_USER"]);
            $manager->persist($fakeUser);

        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 1;
    }
}
