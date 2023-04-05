<?php namespace App\EventListener;

use App\Config\SystemLogPriorityType;
use App\Service\SystemLoggerService;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;

#[AsEventListener(event: WorkerMessageFailedEvent::class, method: 'onMessageFailed')]
class WorkerMessageFailedEventListener
{

    public function __construct(private SystemLoggerService $systemLogService)
    {
    }

    public function onMessageFailed(WorkerMessageFailedEvent $event)
    {

        // if ($event->willRetry()) {
        //     return;
        // }


        // Message Is Failed
        $failedMessageThrowable = $event->getThrowable();

        $this->systemLogService->createLog("An error occured handling message.", SystemLogPriorityType::HIGH, NULL, NULL, $failedMessageThrowable);

    }

}
