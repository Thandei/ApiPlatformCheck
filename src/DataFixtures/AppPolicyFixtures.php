<?php

namespace App\DataFixtures;

use App\Entity\AppPolicy;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AppPolicyFixtures extends AppFixtures implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        foreach (self::POLICIES as $policy) {
            $myPolicy = new AppPolicy();
            $myPolicy->setKeyname($policy["keyname"]);
            $myPolicy->setName($policy["name"]);
            $myPolicy->setContent($policy["content"]);
            $manager->persist($myPolicy);
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 0;
    }
}
