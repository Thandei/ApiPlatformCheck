<?php

namespace App\DataFixtures;

use App\Config\SystemLogPriorityType;
use App\Service\SystemLoggerService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SystemLogFixtures extends AppFixtures
{

    public function __construct(private SystemLoggerService $systemLoggerService)
    {
        parent::__construct();
    }

    public function load(ObjectManager $manager): void
    {
        // Create Fake Logs
        for ($x = 0; $x < AppFixtures::SYSTEM_LOG_COUNT; $x++) {
            $this->systemLoggerService->createLog($this->fakerFactory->paragraph(3));
        }

    }
}
