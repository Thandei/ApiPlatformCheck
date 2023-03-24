<?php namespace App\Controller\Api;

use App\Controller\ApplicationBaseController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiBaseController extends ApplicationBaseController
{


    public function provide(mixed $providerData, bool $operationSuccess = TRUE, string|null $providerMessage = NULL): JsonResponse
    {
        return new  JsonResponse([
            "success" => $operationSuccess,
            "data" => $providerData,
            "message" => $providerMessage
        ]);
    }

}