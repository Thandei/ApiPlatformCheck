<?php

namespace App\Controller\Admin;

use App\Controller\ApplicationBaseController;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\GoogleSigninAuthenticator;
use App\Security\LoginFormAuthenticator;
use Google_Client;
use Google_Service_Oauth2;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\Provider\FacebookClient;
use League\OAuth2\Client\Provider\Facebook;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route(path: '/admin/auth', name: 'app_admin_auth_')]
class AuthController extends AdminBaseController
{

    const SCOPES_GOOGLE = ['email', 'profile'];
    const SCOPES_FACEBOOK = ['public_profile', 'email'];
    const ROUTE_NORMAL = 'app_admin_auth_signin';
    const ROUTE_FACEBOOK = 'app_admin_auth_redirect_facebook';
    const ROUTE_GOOGLE = 'app_admin_auth_redirect_google';

    #[Route(path: '/signin', name: 'signin')]
    public function authSignin(Request $request, AuthenticationUtils $authenticationUtils, ClientRegistry $clientRegistry, Security $security, UserRepository $userRepository): Response
    {

        // If user is logged, redirect to dashboard
        if ($this->getUser()) {
            return $this->redirectToRoute('app_admin_dashboard');
        }

        // Push The Latest Error & Last Username If Exists
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('admin/auth/signin.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/signout', name: 'signout')]
    public function authSignout(): void
    {
        // throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/redirect/google', name: 'redirect_google')]
    public function redirectForGoogle(Request $request, ClientRegistry $clientRegistry): Response
    {
        return $clientRegistry->getClient('google_main')->redirect(self::SCOPES_GOOGLE);;
    }

    #[Route(path: '/redirect/facebook', name: 'redirect_facebook')]
    public function redirectForFacebook(Request $request, ClientRegistry $clientRegistry): Response
    {
        return $clientRegistry->getClient('facebook_main')->redirect(self::SCOPES_FACEBOOK);
    }

    #[Route(path: '/getback/google', name: 'getback_google')]
    public function getBackForGoogle(): Response
    {
        return $this->redirectToRoute('app_admin_dashboard');
    }

    #[Route(path: '/getback/facebook', name: 'getback_facebook')]
    public function getBackForFacebook(): Response
    {
        return $this->redirectToRoute('app_admin_dashboard');
    }

}
