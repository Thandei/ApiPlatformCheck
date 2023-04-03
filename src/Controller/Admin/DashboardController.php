<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Facebook\Facebook;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Flex\Configurator\ContainerConfigurator;

#[Route('/admin', name: 'app_admin_')]
class DashboardController extends AdminBaseController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(MailerInterface $mailer, TransportInterface $transport): Response
    {
        $myMail = new NotificationEmail();
        $myMail->from("noreply@meehou.app");
        $myMail->to("sinansahinwm@gmail.com");
        $myMail->content("deneme mail");
        $myMail->subject("deneme konu");

        $transport->send($myMail);

        return $this->render('admin/dashboard/index.html.twig');
    }
}
