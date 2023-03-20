<?php namespace App\Security;

use App\Repository\AccessTokenRepository;
use SensitiveParameter;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class AccessTokenHandler implements AccessTokenHandlerInterface
{

    public function __construct(private AccessTokenRepository $accessTokenRepository)
    {
    }

    public function getUserBadgeFrom(#[SensitiveParameter] string $accessToken): UserBadge
    {
        // Search Token
        $accessToken = $this->accessTokenRepository->findOneBy(["token" => $accessToken]);

        if (null === $accessToken || !$accessToken->isValid()) {
            throw new BadCredentialsException('Invalid credentials.');
        }


        // Authorize
        return new UserBadge($accessToken->getUser()->getId());
    }
}