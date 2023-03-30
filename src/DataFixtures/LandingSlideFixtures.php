<?php

namespace App\DataFixtures;

use App\Entity\LandingSlide;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LandingSlideFixtures extends AppFixtures implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        foreach (self::LANDING_SLIDES as $landingSlide) {
            $mySlide = new LandingSlide();
            $mySlide->setTags($landingSlide["tags"]);
            $mySlide->setTextcontent($landingSlide["content"]);
            $manager->persist($mySlide);
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 0;
    }
}
