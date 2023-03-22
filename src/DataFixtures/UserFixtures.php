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

            $fakePasswordPlainString = $this->fakerFactory->password(8, 12);
            $hashedPassword = (AppFixtures::USER_DONT_USE_HASH === TRUE) ? $fakePasswordPlainString : $this->passwordHasher->hashPassword($fakeUser, $fakePasswordPlainString);

            $fakeUser->setEmail($this->fakerFactory->email);
            $fakeUser->setPassword($hashedPassword);
            $fakeUser->setAccountname($this->fakerFactory->firstName . " " . $this->fakerFactory->lastName);
            $fakeUser->setNickname($this->fakerFactory->userName);
            $fakeUser->setRoles([AppFixtures::USERS_FAKE_ROLES[array_rand(AppFixtures::USERS_FAKE_ROLES)]]);
            $manager->persist($fakeUser);

        }

        // Persist Admin Users
        $fakeAdmin = new User();
        $fakeAdmin->setEmail(AppFixtures::USER_FAKE_ADMIN);
        $fakeAdmin->setPassword($this->passwordHasher->hashPassword($fakeAdmin, AppFixtures::USER_FAKE_ADMIN_PASSWORD));
        $fakeAdmin->setAccountname(AppFixtures::USER_FAKE_ADMIN_ACCOUNT_NAME);
        $fakeAdmin->setNickname(AppFixtures::USER_FAKE_ADMIN_NICK_NAME);
        $fakeAdmin->setRoles(["ROLE_ADMIN"]);
        $manager->persist($fakeAdmin);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 1;
    }
}
