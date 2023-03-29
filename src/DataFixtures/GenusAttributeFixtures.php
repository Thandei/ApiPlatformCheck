<?php

namespace App\DataFixtures;

use App\Entity\GenusAttribute;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GenusAttributeFixtures extends AppFixtures implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        foreach (AppFixtures::GENUS_ATTR as $attribute) {
            $myAttr = new GenusAttribute();
            $myAttr->setName('app.genusattribute.' . $attribute["name"]);
            $myAttr->setUnit($attribute["unit"]);
            $manager->persist($myAttr);
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 0;
    }

}
