<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ServiceFixtures extends AppFixtures implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        foreach (AppFixtures::SERVICES as $serviceData) {
            $myService = new Service();
            $myService->setName($serviceData["name"]);
            $myService->setDescription($serviceData["description"]);
            $manager->persist($myService);
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 0;
    }
}
