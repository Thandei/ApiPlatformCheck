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
    public function index(GithubDocumentationSyncService $githubDocumentationSyncService): Response
    {


        $myDocumentation = $githubDocumentationSyncService->getApplicationDocumentation("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", "sinansahinwm", "meehoudocs");




        exit(json_encode($myDocumentation));

        return $this->render('admin/dashboard/index.html.twig');
    }
}
