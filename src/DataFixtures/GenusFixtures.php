<?php

namespace App\DataFixtures;

use App\Entity\Genus;
use App\Repository\GenusAttributeRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GenusFixtures extends Fixture implements OrderedFixtureInterface
{

    public function __construct(private GenusAttributeRepository $genusAttributeRepository)
    {
    }

    public function load(ObjectManager $manager): void
    {

        $genusAttrs = $this->genusAttributeRepository->findAll();

        foreach (AppFixtures::GENUSES as $genus) {

            $genusName = strtolower('app.genus.' . $genus["name"] . '|trans');

            $myGenus = new Genus();
            $myGenus->setName($genusName);

            foreach ($genusAttrs as $genusAttr) {
                $myGenus->addAttr($genusAttr);
            }

            $manager->persist($myGenus);

        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 0;
    }
}
