<?php namespace App\Message;

class EmailNotification
{

    public function __construct(
        private string      $to,
        private string|null $subject,
        private string      $template,
        private array       $context = [],
        private int|null    $priority = NULL,
        private string|null $actionURL = NULL,
        private string|null $actionText = NULL,
    )
    {
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @param string $to
     */
    public function setTo(string $to): void
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

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate(string $template): void
    {
        $this->template = $template;
    }

    /**
     * @return array
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * @param array $context
     */
    public function setContext(array $context): void
    {
        $this->context = $context;
    }

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

    /**
     * @return string|null
     */
    public function getActionURL(): ?string
    {
        return $this->actionURL;
    }

    /**
     * @param string|null $actionURL
     */
    public function setActionURL(?string $actionURL): void
    {
        $this->actionURL = $actionURL;
    }

    /**
     * @return string|null
     */
    public function getActionText(): ?string
    {
        return $this->actionText;
    }

    /**
     * @param string|null $actionText
     */
    public function setActionText(?string $actionText): void
    {
        $this->actionText = $actionText;
    }


}