<?php

namespace App\DataFixtures;

use App\Entity\AccessToken;
use App\Repository\AccessTokenRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;

class AccessTokenFixtures extends Fixture implements OrderedFixtureInterface
{

    public function __construct(private UserRepository $userRepository, private AccessTokenRepository $accessTokenRepository)
    {
    }

    public function load(ObjectManager $manager): void
    {

        $fakeUsers = $this->userRepository->findAll();

        foreach ($fakeUsers as $fakeUser) {

            for ($x = 0; $x < AppFixtures::ACCESS_TOKEN_PER_USER; $x++) {

                $fakeAccessToken = $this->generateAccessToken();
                $isExist = $this->accessTokenRepository->findOneBy(["token" => $fakeAccessToken]);

                while ($isExist instanceof AccessToken) {
                    $fakeAccessToken = $this->generateAccessToken();
                    $isExist = $this->accessTokenRepository->findOneBy(["token" => $fakeAccessToken]);
                }

                $randomValid = AppFixtures::ACCESS_TOKEN_POSSIBLE_VALID_POSITIONS[array_rand(AppFixtures::ACCESS_TOKEN_POSSIBLE_VALID_POSITIONS)];

                $fakeToken = new AccessToken();
                $fakeToken->setToken($fakeAccessToken);
                $fakeToken->setUser($fakeUser);
                $fakeToken->setValid($randomValid);
                $manager->persist($fakeToken);

            }

        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 2;
    }

    /**
     * @return string
     * @throws Exception
     */
    public static function generateAccessToken(): string
    {
        return bin2hex(random_bytes(60));
    }
}
