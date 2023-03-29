<?php

namespace App\Controller\Admin\Helpers;

use ApiPlatform\Api\UrlGeneratorInterface;
use App\Controller\Admin\AdminBaseController;
use App\Service\GithubDocumentationSyncService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

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

    #[Route('/backend/api', name: 'backend_api')]
    public function redirectBackendAPI(UrlGeneratorInterface $urlGenerator, Environment $twig): RedirectResponse
    {
        return $this->redirect($twig->getGlobals()["shared"]["appApiBaseURL"]);
    }

}
