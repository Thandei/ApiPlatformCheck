<?php

namespace App\Controller\Admin;

use App\Controller\ApplicationBaseController;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\GoogleSigninAuthenticator;
use App\Security\LoginFormAuthenticator;
use Google_Client;
use Google_Service_Oauth2;
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
    #[Route(path: '/signin', name: 'signin')]
    public function authSignin(Request $request, AuthenticationUtils $authenticationUtils, Security $security, UserRepository $userRepository): Response
    {

        // If User is logged, redirect immediately.
        if ($this->getUser()) {
            return $this->redirectToRoute('app_admin_dashboard');
        }

        // Push The Latest Error & Last Username If Exists
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        // If User is not logged, create Google Client link for Sign In to Google
        $myGoogleClient = AuthController::getGoogleAPIClient($this->getParameter("app.auth"));
        $googleClientAuthURL = $myGoogleClient->createAuthUrl();

        return $this->render('admin/auth/signin.html.twig', ['last_username' => $lastUsername, 'error' => $error, "googleAuthURL" => $googleClientAuthURL]);
    }

    #[Route(path: '/signout', name: 'signout')]
    public function logout(): void
    {
        // throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    public static function getGoogleAPIClient(array $authConfigParams): Google_Client
    {

        $clientConfig = $authConfigParams["google_client"];
        $clientID = $clientConfig["google_client_id"];
        $clientSecret = $clientConfig["google_client_secret"];
        $redirectURL = $clientConfig["google_client_redirecturl"];
        $scopes = $clientConfig["google_client_scopes"];

        $myGoogleClient = new Google_Client();
        $myGoogleClient->setClientId($clientID);
        $myGoogleClient->setClientSecret($clientSecret);
        $myGoogleClient->setRedirectUri($redirectURL);

        foreach ($scopes as $scope) {
            $myGoogleClient->addScope($scope);
        }

        return $myGoogleClient;

    }
}
