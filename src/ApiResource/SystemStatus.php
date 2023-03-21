<?php namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[ApiResource(
    uriTemplate: "system_status",
    shortName: "Get System Status",
    operations: [
        new Get()
    ],
    provider: SystemStatusProvider::class
)]
#[AsController]
class SystemStatus
{

    public $status;

    public function getStatus()
    {
        return $this->status;
    }

}