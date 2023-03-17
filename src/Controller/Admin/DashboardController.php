<?php

namespace App\Controller\Admin;

use App\Service\GithubDocumentationSyncService;
use Github\AuthMethod;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'app_admin_')]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        return $this->render('admin/dashboard/index.html.twig');
    }
}
