<?php

namespace App\DataFixtures;

use App\Entity\AccessToken;
use App\Entity\User;
use DateTimeImmutable;
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
                $manager = $this->persistUser($myUser, $manager);

            }

        }

        // CREATE RANDOM TEST ACCOUNT
        $testUser = new User();
        $testUser->setRoles(["ROLE_USER", "ROLE_ADMIN"]);
        $testUser->setNickname("system.admin");
        $testUser->setAccountname("System Administrator");
        $testUser->setEmail("sinansahinwm@gmail.com");
        $testUser->setPassword($this->passwordHasher->hashPassword($testUser, "321"));
        $manager = $this->persistUser($testUser, $manager);


        $manager->flush();

    }

    private function persistUser(User $user, ObjectManager $manager): ObjectManager
    {
        // Persist User
        $manager->persist($user);

        // Create API Access Token
        $this->createAccessTokens($user, $manager);

        return $manager;
    }

    public function createAccessTokens(User $user, ObjectManager $manager): void
    {

        $dtRandom = $this->fakerFactory->dateTimeBetween("-3 years", "now");
        $dtRandomImmutable = DateTimeImmutable::createFromMutable($dtRandom);

        $myToken = new AccessToken();
        $myToken->setUser($user);
        $myToken->setValid(TRUE);
        $myToken->setToken(md5($this->fakerFactory->password(20)));
        $myToken->setCreatedAt($dtRandomImmutable);
        $manager->persist($myToken);
        $manager->flush();
    }
}
