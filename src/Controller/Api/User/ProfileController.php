<?php

namespace App\Controller\Api\User;

use App\Controller\Api\ApiBaseController;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/granted', name: 'api_')]
class ProfileController extends ApiBaseController
{
    #[Route('/user', name: 'user')]
    public function user(): JsonResponse
    {
        return $this->provide($this->getUser()->getUserIdentifier());
    }

}
