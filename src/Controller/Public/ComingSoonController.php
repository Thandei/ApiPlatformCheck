<?php

namespace App\Controller\Public;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComingSoonController extends AbstractController
{
    #[Route('/', name: 'app_coming_soon')]
    public function index(): Response
    {
        return $this->render('public/coming_soon/index.html.twig');
    }
}
