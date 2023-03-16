<?php

namespace App\Controller\Public;

use App\Controller\ApplicationBaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComingSoonController extends ApplicationBaseController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('public/coming_soon/index.html.twig');
    }
}
