<?php namespace App\ApiResource;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SystemStatusProvider extends AbstractController implements ProviderInterface
{

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return ["position" => TRUE];
    }

}