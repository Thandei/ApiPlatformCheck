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
    const USERS_COUNT = 10;
    const ACCESS_TOKEN_PER_USER = 3;
    const ACCESS_TOKEN_POSSIBLE_VALID_POSITIONS = [NULL, TRUE, FALSE];


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
