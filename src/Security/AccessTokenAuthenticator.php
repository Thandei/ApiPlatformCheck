<?php

namespace App\Security;

use App\Repository\AccessTokenRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class AccessTokenAuthenticator extends AbstractAuthenticator
{

    const AUTHORIZATION_HEADER_PLACEHOLDER = "authorization";
    const AUTHORIZATION_TYPE_PLACEHOLDER = "Bearer";

    public function __construct(private AccessTokenRepository $accessTokenRepository)
    {
    }

    public function supports(Request $request): ?bool
    {
        if ($request->headers->has(self::AUTHORIZATION_HEADER_PLACEHOLDER)) {
            return str_starts_with($request->headers->get(self::AUTHORIZATION_HEADER_PLACEHOLDER), self::AUTHORIZATION_TYPE_PLACEHOLDER);
        }
        return FALSE;
    }

    public function authenticate(Request $request): Passport
    {

        $bearerHeader = $request->headers->get(self::AUTHORIZATION_HEADER_PLACEHOLDER);
        $bearerToken = trim(substr($bearerHeader, strpos($bearerHeader, self::AUTHORIZATION_TYPE_PLACEHOLDER) + strlen(self::AUTHORIZATION_TYPE_PLACEHOLDER)));

        return new SelfValidatingPassport(
            new UserBadge($bearerToken, function ($bearerToken) {
                $myAccessToken = $this->accessTokenRepository->findOneBy(["token" => $bearerToken]);

                if (!$myAccessToken) {
                    throw new UserNotFoundException();
                }

                return $myAccessToken->getUser();
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return NULL;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?JsonResponse
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }


}
