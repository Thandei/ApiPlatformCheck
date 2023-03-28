<?php namespace App\ApiResource\Provider;

use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Hook\TranslationGetCollectionHookByName;
use App\ApiResource\Model\ApplicationConfig;
use App\ApiResource\Normalizer\TranslationNormalizer;
use App\Controller\ApplicationBaseController;
use App\Repository\LocaleRepository;
use Datetime;
use Symfony\Component\Yaml\Yaml;
use Twig\Environment;
use function PHPUnit\Framework\fileExists;

class ApplicationConfigProvider extends ApplicationBaseController implements ProviderInterface
{

    const TRANSLATION_FETCH_FORMAT = "yaml";

    public function __construct(private Environment $twig, private string $projectDir, private LocaleRepository $localeRepository)
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

        return $appConfig;
    }


    public function getTranslations(): string
    {
        $localeTranslations = [];
        $locales = $this->localeRepository->findAll();
        foreach ($locales as $locale) {
            $localeCode = $locale->getCode();
            $translationFile = $this->projectDir . DIRECTORY_SEPARATOR . "translations" . DIRECTORY_SEPARATOR . "messages+intl+icu." . $localeCode . ".yaml";
            if (file_exists($translationFile)) {
                $localeTranslations[$localeCode] = Yaml::parseFile($translationFile);
            }
        }

        return json_encode($localeTranslations);
    }
}