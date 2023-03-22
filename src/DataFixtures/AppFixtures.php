<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture implements OrderedFixtureInterface
{

    // === USER FIXTURES CONFIGURATION == //
    const USERS_COUNT = 100;
    const ACCESS_TOKEN_PER_USER = 3;
    const ACCESS_TOKEN_POSSIBLE_VALID_POSITIONS = [NULL, TRUE, FALSE];
    const USERS_FAKE_ROLES = ["ROLE_ADMIN", "ROLE_USER"];
    const USER_FAKE_ADMIN = "sinansahinwm@gmail.com";
    const USER_FAKE_ADMIN_PASSWORD = "321";
    const USER_FAKE_ADMIN_ACCOUNT_NAME = "System Administrator";
    const USER_FAKE_ADMIN_NICK_NAME = "system.admin";
    const USER_DONT_USE_HASH = TRUE;

    public Generator $fakerFactory;

    public function __construct()
    {
        $this->fakerFactory = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $manager->flush();
    }

    public function getOrder(): int
    {
        return 0;
    }
}
