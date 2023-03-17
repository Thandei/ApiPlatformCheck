<?php

namespace App\Controller\Admin;

use App\Service\GithubDocumentationSyncService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'app_admin_')]
class DocumentationController extends AbstractController
{
    #[Route('/documentation', name: 'documentation')]
    public function index(GithubDocumentationSyncService $githubDocumentationSyncService): Response
    {

        $myDocumentation = $githubDocumentationSyncService->getApplicationDocumentation("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", "sinansahinwm", "meehoudocs");
        return $this->render('admin/documentation/index.html.twig', ["documentation" => $myDocumentation]);

    }
}
