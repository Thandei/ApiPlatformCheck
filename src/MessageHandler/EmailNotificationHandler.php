<?php namespace App\MessageHandler;

use App\Config\SystemLogPriorityType;
use App\Message\EmailNotification;
use App\Service\MailerService;
use App\Service\SystemLoggerService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class EmailNotificationHandler
{

    public function __construct(private MailerService $mailerService, private SystemLoggerService $systemLoggerService)
    {
    }

    public function __invoke(EmailNotification $message): void
    {

        $this->mailerService->setTo($message->getTo());
        $this->mailerService->setPriority($message->getPriority());
        $this->mailerService->setSubject($message->getSubject());

        if ($message->getActionURL() !== NULL) {
            $this->mailerService->setAction($message->getActionURL(), $message->getActionText());
        }

        $sendResult = $this->mailerService->send($message->getTemplate(), $message->getContext());

        if ($sendResult === FALSE) {
            $logTexts = ['Sending email failed.', 'Email: ' . $this->mailerService->getTo(), 'Subject: ' . $message->getSubject(), "Context: " . json_encode($message->getContext())];
            $this->systemLoggerService->createLog(implode(PHP_EOL, $logTexts), SystemLogPriorityType::HIGH);
        }

    }

}