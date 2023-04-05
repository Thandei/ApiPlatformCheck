<?php

namespace App\DataFixtures;

use App\Entity\Pet;
use App\Repository\GenusRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\UnicodeString;

class PetFixtures extends AppFixtures implements OrderedFixtureInterface
{

    public function __construct(private UserRepository $userRepository, private GenusRepository $genusRepository)
    {
        parent::__construct();
    }

    public function load(ObjectManager $manager): void
    {

        $users = $this->userRepository->findAll();

        foreach ($users as $user) {
            for ($x = 0; $x < AppFixtures::PETS_PER_USER; $x++) {

                // Get Random Genus
                $allGenusses = $this->genusRepository->findAll();
                shuffle($allGenusses);

                foreach ($allGenusses as $index => $selectedGenus) {
                    if ($index === 0) {
                        $myPet = new Pet();
                        $myPet->setOwner($user);
                        $myPet->setName((new UnicodeString($this->fakerFactory->words(2, TRUE)))->title(true));
                        $myPet->setGenus($selectedGenus);
                        $manager->persist($myPet);
                    }
                }
            }
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 2;
    }

}
