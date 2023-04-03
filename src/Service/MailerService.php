<?php namespace App\Service;

use Symfony\Component\Mailer\Transport\TransportInterface;

class MailerService
{
    public function __construct(TransportInterface $transport)
    {
    }

    public function sendEmail()
    {

    }

}