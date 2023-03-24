<?php

namespace App\Controller\Admin\Helpers;

use App\Controller\Admin\AdminBaseController;
use App\Service\GithubDocumentationSyncService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'app_admin_')]
class DocumentationController extends AdminBaseController
{
    #[Route('/documentation', name: 'documentation')]
    public function documentationMain(Request $request, GithubDocumentationSyncService $githubDocumentationSyncService): Response
    {
        $githubUsername = $this->getParameter('app.admin.documentation.githubUsername');
        $githubToken = $this->getParameter('app.admin.documentation.githubToken');
        $repositoryName = $this->getParameter('app.admin.documentation.repositoryName');
        $myDocumentation = $githubDocumentationSyncService->getApplicationDocumentation($githubToken, $githubUsername, $repositoryName, $request->get("docpath"));
        return $this->render('admin/documentation/index.html.twig', ["documentation" => $myDocumentation]);
    }

}