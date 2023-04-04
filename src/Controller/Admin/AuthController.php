<?php

namespace App\Controller\Admin;

use App\Controller\ApplicationBaseController;
use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use App\Repository\UserRepository;
use App\Security\GoogleSigninAuthenticator;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Google_Client;
use Google_Service_Oauth2;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\Provider\FacebookClient;
use League\OAuth2\Client\Provider\Facebook;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

#[Route(path: '/admin/auth', name: 'app_admin_auth_')]
class AuthController extends AdminBaseController
{

    use ResetPasswordControllerTrait;

    const SCOPES_GOOGLE = ['email', 'profile'];
    const SCOPES_FACEBOOK = ['public_profile', 'email'];
    const ROUTE_NORMAL = 'app_admin_auth_signin';
    const ROUTE_FACEBOOK = 'app_admin_auth_redirect_facebook';
    const ROUTE_GOOGLE = 'app_admin_auth_redirect_google';

    public function __construct(private ResetPasswordHelperInterface $resetPasswordHelper, private EntityManagerInterface $entityManager)
    {
    }

    #[Route('/reset/password/request', name: 'reset_password_request')]
    public function authResetPasswordRequest(Request $request, TransportInterface $transportInterface, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->processSendingPasswordResetEmail(
                $form->get('email')->getData(),
                $transportInterface,
                $translator
            );
        }

        return $this->render('admin/auth/reset_password/request.html.twig', [
            'requestForm' => $form->createView(),
        ]);
    }

    #[Route('/reset/password/check/email', name: 'reset_password_check_email')]
    public function authResetPasswordCheckEmail(): Response
    {

        if (null === ($resetToken = $this->getTokenObjectFromSession())) {
            $resetToken = $this->resetPasswordHelper->generateFakeResetToken();
        }

        return $this->render('admin/auth/reset_password/check_email.html.twig', [
            'resetToken' => $resetToken,
        ]);

    }

    #[Route('/reset/password/token/{token}', name: 'reset_password_reset')]
    public function resetPasswordReset(Request $request, UserPasswordHasherInterface $passwordHasher, TranslatorInterface $translator, string $token = null): Response
    {
        if ($token) {
            // We store the token in session and remove it from the URL, to avoid the URL being
            // loaded in a browser and potentially leaking the token to 3rd party JavaScript.
            $this->storeTokenInSession($token);

            return $this->redirectToRoute('app_admin_auth_reset_password_reset');
        }

        $token = $this->getTokenFromSession();
        if (null === $token) {
            throw $this->createNotFoundException('No reset password token found in the URL or in the session.');
        }

        try {
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
        } catch (ResetPasswordExceptionInterface $e) {
            $this->addFlash('reset_password_error', sprintf(
                '%s - %s',
                $translator->trans(ResetPasswordExceptionInterface::MESSAGE_PROBLEM_VALIDATE, [], 'ResetPasswordBundle'),
                $translator->trans($e->getReason(), [], 'ResetPasswordBundle')
            ));

            return $this->redirectToRoute('app_admin_auth_reset_password_request');
        }

        // The token is valid; allow the user to change their password.
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // A password reset token should be used only once, remove it.
            $this->resetPasswordHelper->removeResetRequest($token);

            // Encode(hash) the plain password, and set it.
            $encodedPassword = $passwordHasher->hashPassword(
                $user,
                $form->get('plainPassword')->getData()
            );

            $user->setPassword($encodedPassword);
            $this->entityManager->flush();

            // The session is cleaned up after the password has been changed.
            $this->cleanSessionAfterReset();

            return $this->redirectToRoute('app_admin_dashboard');
        }

        return $this->render('admin/auth/reset_password/reset.html.twig', [
            'resetForm' => $form->createView(),
        ]);
    }

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

    private function processSendingPasswordResetEmail(string $emailFormData, TransportInterface $transportInterface, TranslatorInterface $translator): RedirectResponse
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => $emailFormData,
        ]);

        // Do not reveal whether a user account was found or not.
        if (!$user) {
            return $this->redirectToRoute('app_admin_auth_reset_password_check_email');
        }

        try {
            $resetToken = $this->resetPasswordHelper->generateResetToken($user);
        } catch (ResetPasswordExceptionInterface $e) {
            return $this->redirectToRoute('app_admin_auth_reset_password_check_email');
        }


        try {

            $email = (new TemplatedEmail())
                ->from(new Address('noreply@meehou.app', 'MeeHou'))
                ->to($user->getEmail())
                ->subject('Your password reset request')
                ->htmlTemplate('email/reset_password.html.twig')
                ->context([
                    'resetToken' => $resetToken,
                ]);

            $transportInterface->send($email);
        } catch (Exception|TransportException|TransportExceptionInterface $exception) {
        }


        // Store the token object in session for retrieval in check-email route.
        $this->setTokenObjectInSession($resetToken);

        return $this->redirectToRoute('app_admin_auth_reset_password_check_email');
    }

}
