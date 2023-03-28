<?php namespace App\Security;

use App\Entity\User;

use App\Repository\UserRepository;
use App\Service\UserRegistrationService;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use League\OAuth2\Client\Provider\FacebookUser;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class FacebookSigninAuthenticator extends OAuth2Authenticator implements AuthenticationEntrypointInterface
{


    public function __construct(private ClientRegistry $clientRegistry, private RouterInterface $router, private AuthenticationSuccessProcessor $authenticationSuccessProcessor, private UserRepository $userRepository, private UserRegistrationService $registrationService)
    {
    }

    public function supports(Request $request): ?bool
    {
        return str_ends_with($request->attributes->get('_controller'), 'getBackForFacebook');
    }

    public function authenticate(Request $request): Passport
    {
        $client = $this->clientRegistry->getClient('facebook_main');
        $accessToken = $this->fetchAccessToken($client);

        return new SelfValidatingPassport(
            new UserBadge($accessToken->getToken(), function () use ($accessToken, $client, $request) {

                $facebookUser = $client->fetchUserFromToken($accessToken);
                $facebookUserData = $facebookUser->toArray();

                $loggedUser = $this->userRepository->findOneBy([
                    "email" => $facebookUserData["email"]
                ]);

                if ($loggedUser instanceof User) {
                    // User Registered
                    return $loggedUser;
                } else {
                    // User Is Not Registered Yet, Try to Register
                    $registerResult = $this->registrationService->registerUserByFacebook($facebookUserData, $request);
                    if ($registerResult instanceof User) {
                        return $registerResult;
                    }
                }

                return new AuthenticationException();

            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return $this->authenticationSuccessProcessor->returnForAuthSuccess($request, $token, $firewallName, AuthenticationSuccessProcessor::AUTHORIZED_BY_FACEBOOK);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return NULL;
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return new RedirectResponse($this->router->generate('app_admin_auth_signin'));
    }
}