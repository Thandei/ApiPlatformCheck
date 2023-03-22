<?php

namespace App\Security;

use App\Controller\Admin\AuthController;
use App\Repository\AccessTokenRepository;
use App\Repository\UserRepository;
use Exception;
use Google_Service_Oauth2;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class GoogleSigninAuthenticator extends AbstractAuthenticator
{

    const GOOGLE_QUERY_PLACEHOLDER = 'code';

    public function __construct(private UserRepository $userRepository, private ParameterBagInterface $parameterBag)
    {
    }

    public function supports(Request $request): ?bool
    {
        return (bool)$request->get(self::GOOGLE_QUERY_PLACEHOLDER, FALSE);
    }

    public function authenticate(Request $request): Passport
    {

        $googleToken = $request->get(self::GOOGLE_QUERY_PLACEHOLDER);

        if (null === $googleToken) {
            throw new CustomUserMessageAuthenticationException('No Google token provided');
        }

        return new SelfValidatingPassport(
            new UserBadge($googleToken, function ($googleToken) {

                $googleClient = AuthController::getGoogleAPIClient($this->parameterBag->get('app.auth'));
                $token = $googleClient->fetchAccessTokenWithAuthCode($googleToken);

                if (isset($token["access_token"])) {
                    $googleClient->setAccessToken($token['access_token']);
                    $googleOAuth = new Google_Service_Oauth2($googleClient);
                    $googleAccountInfo = $googleOAuth->userinfo->get();
                    $loggedEmail = $googleAccountInfo->getEmail();
                    $loggedUser = $this->userRepository->findOneBy(["email" => $loggedEmail]);
                    if (!$loggedUser) {
                        throw new UserNotFoundException();
                    }
                    return $loggedUser;
                }

                throw new AuthenticationException();

            })
        );

    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return NULL;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return NULL;
    }
}