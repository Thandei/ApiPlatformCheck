<?php

namespace App\DataFixtures;

use App\Entity\Locale;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LocaleFixtures extends AppFixtures implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager): void
    {

        foreach (self::LOCALES as $locale) {
            $myLocale = new Locale();
            $myLocale->setName($locale["name"]);
            $myLocale->setCode($locale["code"]);
            $myLocale->setFlag($locale["flag"]);
            $myLocale->setSystemsdefault($locale["systemsdefault"]);
            $manager->persist($myLocale);
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 0;
    }
}
