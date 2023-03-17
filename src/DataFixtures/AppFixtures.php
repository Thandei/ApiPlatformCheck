<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    const USERS_COUNT = 5;
    const USERS_ROLE_TYPES = ["ROLE_USER", "ROLE_ADMIN"];
    const USER_SKIP_HASH_PASSWORDS = FALSE;

    const USER_GENERATE_RANDOM_PASSWORD = "321";

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
