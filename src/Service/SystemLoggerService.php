<?php namespace App\Service;

use App\Config\SystemLogPriorityType;
use App\Entity\SystemLog;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class SystemLoggerService
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function createLog(string $logContent, string $logPriority = SystemLogPriorityType::NORMAL, ?Request $logRequest = NULL, ?User $logUser = NULL): SystemLog
    {
        $myLog = new SystemLog();
        $myLog->setPriority($logPriority);
        $myLog->setContent($logContent);

        // If Request Served
        if ($logRequest !== NULL) {
            $myLog->setRequestip($logRequest->getClientIp());
        }

        // If User Served
        if ($logUser instanceof User) {
            $myLog->setRelateduserid($logUser->getId());
        }

        $this->entityManager->persist($myLog);
        $this->entityManager->flush();
        return $myLog;
    }

}