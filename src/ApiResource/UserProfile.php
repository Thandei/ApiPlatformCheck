<?php namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Entity\User;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/user',
            read: true,
            write: false,
            provider: UserProfileProvider::class
        )
    ]
)]
class UserProfile
{

    private ?User $user = null;

}