<?php namespace App\ApiResource\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Model\ApplicationConfig;
use App\Controller\Admin\AuthController;
use App\Controller\ApplicationBaseController;
use App\Repository\LandingSlideRepository;
use App\Repository\LocaleRepository;
use App\Security\AuthenticationSuccessProcessor;
use Symfony\Component\Yaml\Yaml;
use Twig\Environment;

class ApplicationConfigProvider extends ApplicationBaseController implements ProviderInterface
{

    public function __construct(private Environment $twig, private string $projectDir, private LocaleRepository $localeRepository, private LandingSlideRepository $landingSlideRepository)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {

        $twigGlobals = $this->twig->getGlobals();

        $appConfig = new ApplicationConfig();
        $appConfig->setUnderMaintance($twigGlobals["shared"]["underMaintance"]);
        $appConfig->setAppName($twigGlobals["shared"]["appTitle"]);
        $appConfig->setAppBaseURL($twigGlobals["shared"]["appBaseURL"]);
        $appConfig->setAppApiBaseURL($twigGlobals["shared"]["appApiBaseURL"]);
        $appConfig->setAppLogo($twigGlobals["shared"]["appLogo"]);
        $appConfig->setAppFavicon($twigGlobals["admin"]["favicon"]);
        $appConfig->setDeveloperTitle($twigGlobals["shared"]["developerTitle"]);
        $appConfig->setDeveloperURL($twigGlobals["shared"]["developerURL"]);
        $appConfig->setTranslations($this->getTranslations());
        $appConfig->setLocales($this->localeRepository->findAll());

        // Authentication
        $appConfig->setAuthWithUsernamePasswordURL($this->generateUrl(AuthController::ROUTE_NORMAL));
        $appConfig->setAuthWithFacebookURL($this->generateUrl(AuthController::ROUTE_FACEBOOK));
        $appConfig->setAuthWithGoogleURL($this->generateUrl(AuthController::ROUTE_GOOGLE));
        $appConfig->setAuthCatchTokenByHeader(AuthenticationSuccessProcessor::WHEN_REDIRECT_ADD_TOKEN_TO_RESPONSE);

        return $appConfig;
    }


    public function getTranslations(): string
    {
        $localeTranslations = [];
        $locales = $this->localeRepository->findAll();
        foreach ($locales as $locale) {
            $localeCode = $locale->getCode();
            $translationFile = $this->projectDir . DIRECTORY_SEPARATOR . "translations" . DIRECTORY_SEPARATOR . "messages+intl-icu." . $localeCode . ".yaml";
            if (file_exists($translationFile)) {
                $localeTranslations[$localeCode] = Yaml::parseFile($translationFile);
            }
        }

        return json_encode($localeTranslations);
    }
}