<?php namespace App\MessageHandler;

use App\Message\EmailNotification;
use App\Service\MailerService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class EmailNotificationHandler
{

    public function __construct(private MailerService $mailerService)
    {
    }

    public function __invoke(EmailNotification $message): void
    {

        $this->mailerService->setTo($message->getTo());
        $this->mailerService->setPriority($message->getPriority());
        $this->mailerService->setSubject($message->getSubject());
        $this->mailerService->setAction($message->getActionURL(), $message->getActionText());
        $this->mailerService->send($message->getTemplate(), $message->getContext());

    }

}