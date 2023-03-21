<?php namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[ApiResource(
    uriTemplate: "system_status",
    shortName: "Get System Status",
    operations: [
        new Get(
            controller: SystemStatus::class
        )
    ]
)]
#[AsController]
class SystemStatus extends AbstractController
{

    /**
     * @var bool $status
     */
    private bool $status = FALSE;

}