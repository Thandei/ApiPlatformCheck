<?php namespace App\Security;

use ApiPlatform\Api\UrlGeneratorInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AuthenticationSuccessProcessor
{

    const AUTHORIZED_BY_LOGIN_FORM = 'login_form';
    const AUTHORIZED_BY_GOOGLE = 'google';
    const AUTHORIZED_BY_FACEBOOK = 'facebook';
    const WHEN_REDIRECT_ADD_TOKEN_TO_RESPONSE = 'meehoutoken';

    public function __construct(private JWTTokenManagerInterface $JWTTokenManager, private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function returnForAuthSuccess(Request $request, TokenInterface $token, string $firewallName, string $authorizedBy = self::AUTHORIZED_BY_LOGIN_FORM): ?Response
    {

        if ($token->getUser()) {
            $returnedResultHeaders = [
                self::WHEN_REDIRECT_ADD_TOKEN_TO_RESPONSE => $this->JWTTokenManager->create($token->getUser())
            ];

            if ($authorizedBy === self::AUTHORIZED_BY_LOGIN_FORM) {
                return new RedirectResponse($this->urlGenerator->generate(LoginFormAuthenticator::LOGIN_SUCCESS_ROUTE), 302, $returnedResultHeaders);
            } elseif ($authorizedBy === self::AUTHORIZED_BY_GOOGLE) {
                return new RedirectResponse($this->urlGenerator->generate(LoginFormAuthenticator::LOGIN_SUCCESS_ROUTE), 302, $returnedResultHeaders);
            } elseif ($authorizedBy === self::AUTHORIZED_BY_FACEBOOK) {
                return new RedirectResponse($this->urlGenerator->generate(LoginFormAuthenticator::LOGIN_SUCCESS_ROUTE), 302, $returnedResultHeaders);

            }
        }

        return NULL;
    }
}