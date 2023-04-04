<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use App\Service\MailerService;
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
    public function index(MailerService $mailerService): Response
    {


        // $mailerService->setFrom("noreply@meehou.app");
        // $mailerService->setTo("sinansahinwm@gmail.com");
        // $mailerService->setSubject("DENEME");
        // $mailerService->setAction('#', 'Hemen Tıklaa!!!');
        // $mailerService->setPriority(MailerService::PRIORITY_HIGH);
        // $sendResult = $mailerService->send('test', ["resetToken" => "deee"]);

        // exit(var_dump($sendResult));
        return $this->render('admin/dashboard/index.html.twig');
    }

}
