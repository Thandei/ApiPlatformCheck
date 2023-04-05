<?php

namespace App\DataFixtures;

use App\Entity\GenusAttributeValue;
use App\Repository\PetRepository;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GenusAttributeValueFixtures extends AppFixtures implements OrderedFixtureInterface
{

    public function __construct(private PetRepository $petRepository)
    {
        parent::__construct();
    }

    public function load(ObjectManager $manager): void
    {

        $pets = $this->petRepository->findAll();

        foreach ($pets as $pet) {
            $petGenus = $pet->getGenus();
            $genusAttributes = $petGenus->getAttr();


            foreach ($genusAttributes as $index => $genusAttribute) {
                $myAttrVal = new GenusAttributeValue();
                $myAttrVal->setAttribute($genusAttribute);
                $myAttrVal->setPet($pet);
                $manager->persist($myAttrVal);
            }

        }

        $manager->flush();

    }

    public function getOrder(): int
    {
        return 3;
    }

}
