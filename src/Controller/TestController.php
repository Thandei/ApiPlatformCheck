<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('admin/test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    #[Route('/testa', name: 'app_testa')]
    public function indexa(): Response
    {
        return $this->render('admin/test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
}