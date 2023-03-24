<?php

namespace App\Controller\Admin;

use App\Service\GithubDocumentationSyncService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'app_admin_')]
class DocumentationController extends AbstractController
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

    #[Route('/documentation/swagger', name: 'documentation_swagger')]
    public function documentationSwagger(Request $request): Response
    {
        return $this->render('admin/documentation/swagger.html.twig');
    }

    #[Route('/documentation/swagger/json', name: 'documentation_swagger_json')]
    public function documentationSwaggerJSON(Request $request): Response
    {
        return $this->render('admin/documentation/api.json.twig', []);
    }

}
