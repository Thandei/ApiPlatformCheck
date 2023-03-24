<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Flex\Configurator\ContainerConfigurator;

#[Route('/admin', name: 'app_admin_')]
class DashboardController extends AdminBaseController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(UserRepository $userRepository, ContainerConfigurator $configurator): Response
    {

        return $this->render('admin/dashboard/index.html.twig');
    }
}
