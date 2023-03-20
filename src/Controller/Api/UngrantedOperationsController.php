<?php

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/grantless', name: 'api_')]
class UngrantedOperationsController extends ApiBaseController
{
    #[Route('/system/status', name: 'system_status')]
    public function systemStatus(): JsonResponse
    {
        return $this->provide(TRUE, TRUE);
    }

    #[Route('/system/time', name: 'system_time')]
    public function systemTime(): JsonResponse
    {
        return $this->provide(time(), TRUE);
    }


}
