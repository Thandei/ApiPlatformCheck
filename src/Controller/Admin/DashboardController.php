<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'app_admin_')]
class DashboardController extends AdminBaseController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(MessageBusInterface $messageBus): Response
    {


        // $myEmail = new EmailNotification("sinansahinwm@gmail.com", "Deneme Konu", 'test', ["sdgsdg" => "sdgsdgsdg"], MailerService::PRIORITY_HIGH);
        // $messageBus->dispatch($myEmail, [new DelayStamp(500)]);

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
