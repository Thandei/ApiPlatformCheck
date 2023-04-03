<?php namespace App\Service;

use Exception;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bridge\Twig\Mime;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Address;


class MailerService
{

    public const DEFAULT_MAILER_SENDER = 'noreply@meehou.app';
    public const PRIORITY_HIGHEST = 1;
    public const PRIORITY_HIGH = 2;
    public const PRIORITY_NORMAL = 3;
    public const PRIORITY_LOW = 4;
    public const PRIORITY_LOWEST = 5;


    private ?string $subject = NULL;
    private null|string|Address $to = NULL;
    private null|string|Address $from = self::DEFAULT_MAILER_SENDER;
    private null|int $priority = NULL;

    /**
     * @return int|null
     */
    public function getPriority(): ?int
    {
        return $this->priority;
    }

    /**
     * @param int|null $priority
     */
    public function setPriority(?int $priority): void
    {
        $this->priority = $priority;
    }

    private ?array $mailAction = NULL;

    private array $errorLog = [];

    /**
     * @return array
     */
    public function getErrorLog(): array
    {
        return $this->errorLog;
    }

    /**
     * @param array $errorLog
     */
    public function setErrorLog(array $errorLog): void
    {
        $this->errorLog = $errorLog;
    }

    public function addError(string $errorString): void
    {
        $this->errorLog[] = $errorString;
    }


    /**
     * @return string|Address|null
     */
    public function getFrom(): Address|string|null
    {
        return $this->from;
    }

    /**
     * @param string|Address|null $from
     */
    public function setFrom(Address|string|null $from): void
    {
        $this->from = $from;
    }

    /**
     * @return string|Address|null
     */
    public function getTo(): Address|string|null
    {
        return $this->to;
    }

    /**
     * @param string|Address|null $to
     */
    public function setTo(Address|string|null $to): void
    {
        $this->to = $to;
    }

    /**
     * @return string|null
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @param string|null $subject
     */
    public function setSubject(?string $subject): void
    {
        $this->subject = $subject;
    }

    public function __construct(private TransportInterface $transport)
    {
    }

    public function setAction(string $actionURL, string $actionText)
    {
        $this->mailAction = ["url" => $actionURL, "text" => $actionText];
    }

    public function send(string $templateFile, array $dataContext = []): bool
    {
        try {

            $myMail = $this->getTemplatedEmail();
            $myMail->htmlTemplate('email' . DIRECTORY_SEPARATOR . $templateFile . '.html.twig');
            $myMail->context($this->prepareContext($dataContext));
            $this->transport->send($myMail);

            return TRUE;

        } catch (Exception|TransportExceptionInterface $exception) {
            $this->addError($exception->getMessage());
        }


        return FALSE;
    }

    private function getTemplatedEmail(): TemplatedEmail
    {

        $myMail = new TemplatedEmail();
        $myMail->from($this->getFrom());
        $myMail->to($this->getTo());
        $myMail->subject($this->getSubject());
        if ($this->priority !== NULL) {
            $myMail->priority($this->getPriority());
        }
        return $myMail;
    }

    private function prepareContext(array $context = []): array
    {
        if ($this->mailAction !== NULL) {
            $context["action"] = $this->mailAction;
        }
        return $context;
    }

}