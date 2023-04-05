<?php namespace App\Service;

use App\Config\SystemLogPriorityType;
use App\Entity\SystemLog;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class SystemLoggerService
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function createLog(string $logContent, string $logPriority = SystemLogPriorityType::NORMAL, ?Request $logRequest = NULL, ?User $logUser = NULL, ?Throwable $throwable = NULL): SystemLog
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

        // If Trace is Available
        if ($throwable instanceof Throwable) {
            $myLog->setTrace($this->prepareTraceForThrowable($throwable));
        }

        $this->entityManager->persist($myLog);
        $this->entityManager->flush();
        return $myLog;
    }


    private function prepareTraceForThrowable(Throwable $failedMessageThrowable): string
    {

        $traceTexts = [];
        $traceTexts[] = "# File: " . $failedMessageThrowable->getFile();
        $traceTexts[] = "# Line: " . $failedMessageThrowable->getLine();
        $traceTexts[] = "# Code: " . $failedMessageThrowable->getCode();
        $traceTexts[] = "# Trace: " . $failedMessageThrowable->getTraceAsString();

        return implode(PHP_EOL, $traceTexts);

    }

}