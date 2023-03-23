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

    const TRANSLATIONS_CONFIG = "/config/packages/translation.yaml";
    const TRANSLATIONS_FILES = "/translations";
    const TRANSLATION_FETCH_FORMAT = "yaml";

    public function __construct(private Environment $twig, private string $projectDir, private LocaleRepository $localeRepository)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {

        $twigGlobals = $this->twig->getGlobals();
        $catalogData = Yaml::parseFile($this->projectDir . self::TRANSLATIONS_CONFIG);

        $supportedLocales = $catalogData["framework"]["translator"]["fallbacks"];
        $translations = $this->getTranslationMessages($this->projectDir . self::TRANSLATIONS_FILES, $supportedLocales);

        $appConfig = new ApplicationConfig();
        $appConfig->setAppName($twigGlobals["shared"]["appTitle"]);
        $appConfig->setAppBaseURL($twigGlobals["shared"]["appBaseURL"]);
        $appConfig->setAppApiBaseURL($twigGlobals["shared"]["appApiBaseURL"]);
        $appConfig->setAppLogo($twigGlobals["shared"]["appLogo"]);
        $appConfig->setAppFavicon($twigGlobals["admin"]["favicon"]);
        $appConfig->setDeveloperTitle($twigGlobals["shared"]["developerTitle"]);
        $appConfig->setDeveloperURL($twigGlobals["shared"]["developerURL"]);
        $appConfig->setSupportedLocales($supportedLocales);
        $appConfig->setDefaultLocale($catalogData["framework"]["default_locale"]);
        $appConfig->setTranslations($translations);
        $appConfig->setLocales($this->localeRepository->findAll());
        $appConfig->setPublicationDate(new Datetime());

        return $appConfig;
    }

    public function getTranslationMessages(string $translationsDir, array $supportedLocales = []): string
    {

        $myTranslations = [];

        foreach ($supportedLocales as $supportedLocale) {
            $translationFile = $translationsDir . "/messages+intl-icu.$supportedLocale." . self::TRANSLATION_FETCH_FORMAT;
            if (file_exists($translationFile)) {
                $myTranslations[$supportedLocale] = Yaml::parseFile($translationFile);
            }
        }

        return json_encode($myTranslations);
    }
}