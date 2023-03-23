<?php namespace App\ApiResource\Model;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Link;
use App\ApiResource\Normalizer\TranslationNormalizer;
use App\ApiResource\Provider\ApplicationConfigProvider;
use App\Entity\Locale;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ApiResource(
    shortName: "Application Config",
    operations: [
        new Get(
            uriTemplate: '/application_config',
            provider: ApplicationConfigProvider::class
        )
    ]
)]
class ApplicationConfig
{

    #[ApiProperty(readable: true)]
    public ?string $appName = NULL;

    #[ApiProperty(readable: true)]
    public ?string $appBaseURL = NULL;

    #[ApiProperty(readable: true)]
    public ?string $appApiBaseURL = NULL;

    #[ApiProperty(readable: true)]
    public ?string $appLogo = NULL;

    #[ApiProperty(readable: true)]
    public ?string $appFavicon = NULL;

    #[ApiProperty(readable: true)]
    public ?string $developerTitle = NULL;

    #[ApiProperty(readable: true)]
    public ?string $developerURL = NULL;

    #[ApiProperty(readable: true)]
    public array $supportedLocales = [];

    #[ApiProperty(readable: true)]
    public ?string $defaultLocale = NULL;

    #[ApiProperty(readable: true)]
    public ?string $translations = NULL;

    #[ApiProperty(readable: true)]
    public array $locales = [];

    #[ApiProperty(readable: true)]
    #[Context([TranslationNormalizer::class])]
    public ?\DateTimeInterface $publicationDate = null;

    /**
     * @return \DateTimeInterface|null
     */
    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    /**
     * @param \DateTimeInterface|null $publicationDate
     */
    public function setPublicationDate(?\DateTimeInterface $publicationDate): void
    {
        $this->publicationDate = $publicationDate;
    }

    /**
     * @return array
     */
    public function getLocales(): array
    {
        return $this->locales;
    }

    /**
     * @param array $locales
     */
    public function setLocales(array $locales): void
    {
        $this->locales = $locales;
    }

    /**
     * @return string|null
     */
    public function getAppName(): ?string
    {
        return $this->appName;
    }

    /**
     * @param string|null $appName
     */
    public function setAppName(?string $appName): void
    {
        $this->appName = $appName;
    }

    /**
     * @return string|null
     */
    public function getAppBaseURL(): ?string
    {
        return $this->appBaseURL;
    }

    /**
     * @param string|null $appBaseURL
     */
    public function setAppBaseURL(?string $appBaseURL): void
    {
        $this->appBaseURL = $appBaseURL;
    }

    /**
     * @return string|null
     */
    public function getAppApiBaseURL(): ?string
    {
        return $this->appApiBaseURL;
    }

    /**
     * @param string|null $appApiBaseURL
     */
    public function setAppApiBaseURL(?string $appApiBaseURL): void
    {
        $this->appApiBaseURL = $appApiBaseURL;
    }

    /**
     * @return string|null
     */
    public function getAppLogo(): ?string
    {
        return $this->appLogo;
    }

    /**
     * @param string|null $appLogo
     */
    public function setAppLogo(?string $appLogo): void
    {
        $this->appLogo = $appLogo;
    }

    /**
     * @return string|null
     */
    public function getAppFavicon(): ?string
    {
        return $this->appFavicon;
    }

    /**
     * @param string|null $appFavicon
     */
    public function setAppFavicon(?string $appFavicon): void
    {
        $this->appFavicon = $appFavicon;
    }

    /**
     * @return string|null
     */
    public function getDeveloperTitle(): ?string
    {
        return $this->developerTitle;
    }

    /**
     * @param string|null $developerTitle
     */
    public function setDeveloperTitle(?string $developerTitle): void
    {
        $this->developerTitle = $developerTitle;
    }

    /**
     * @return string|null
     */
    public function getDeveloperURL(): ?string
    {
        return $this->developerURL;
    }

    /**
     * @param string|null $developerURL
     */
    public function setDeveloperURL(?string $developerURL): void
    {
        $this->developerURL = $developerURL;
    }

    /**
     * @return array
     */
    public function getSupportedLocales(): array
    {
        return $this->supportedLocales;
    }

    /**
     * @param array $supportedLocales
     */
    public function setSupportedLocales(array $supportedLocales): void
    {
        $this->supportedLocales = $supportedLocales;
    }

    /**
     * @return string|null
     */
    public function getDefaultLocale(): ?string
    {
        return $this->defaultLocale;
    }

    /**
     * @param string|null $defaultLocale
     */
    public function setDefaultLocale(?string $defaultLocale): void
    {
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * @return string|null
     */
    public function getTranslations(): ?string
    {
        return $this->translations;
    }

    /**
     * @param string|null $translations
     */
    public function setTranslations(?string $translations): void
    {
        $this->translations = $translations;
    }


}