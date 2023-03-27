<?php

namespace App\Controller\Admin\Helpers;

use App\ApiResource\Normalizer\TranslatableTextNormalizer;
use App\Controller\Admin\AdminBaseController;
use App\Repository\GenusAttributeRepository;
use App\Repository\LocaleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/admin', name: 'app_admin_')]
class DatabaseTranslationController extends AdminBaseController
{

    const TRANSLATION_ATTRIBUTES = ["appName", "name"];
    const TRANSLATION_PREFIX = 'app.database.';
    const REMAKE_DATABASE_TRANSLATIONS_CACHE_TIME = 3600;

    #[Route('/database/translation/remake', name: 'database_translation_remake')]
    public function index(): Response
    {
        $cache = new FilesystemAdapter();

        if (!TranslatableTextNormalizer::ALLOW_REMAKING_DATABASE_TRANSLATIONS) {
            $this->addFlash('pageNotificationError', 'Unable to remake database translations. Please activate Translatable Text Normalizer!');
        } else {
            try {
                $cache->delete('remakeDatabaseTranslations');
                $remakeDatabaseTranslations = $cache->get('remakeDatabaseTranslations', function (ItemInterface $item) {
                    $item->expiresAfter(self::REMAKE_DATABASE_TRANSLATIONS_CACHE_TIME);
                    return TRUE;
                });
                $this->addFlash('pageNotificationSuccess', 'Items fetched from the database by the API for ' . self::REMAKE_DATABASE_TRANSLATIONS_CACHE_TIME . ' seconds will be automatically transferred to the translation file. Important: After this period, no translation file will be automatically created.');
            } catch (InvalidArgumentException) {
                $this->addFlash('pageNotificationError', 'Unable to remake database translations.');
            }
        }


        return $this->redirectToRoute('app_admin_dashboard');
    }


    public static function apiPropertySupportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {

        if (isset($context["api_attribute"])) {
            if (in_array($context["api_attribute"], self::TRANSLATION_ATTRIBUTES)) {
                if (is_string($data)) {
                    return str_starts_with($data, self::TRANSLATION_PREFIX);
                }
            }
        }

        // if (isset($context["request_uri"])) {
        //     if (isset($context["api_attribute"])) {
        //         if (array_key_exists($context["request_uri"], self::VALID_TRANSLATION_OPERATIONS)) {
        //             return self::VALID_TRANSLATION_OPERATIONS[$context["request_uri"]] === $context["api_attribute"];
        //         }
        //     }
        // }


        return FALSE;
    }

    public static function apiPropertyNormalize(TranslatorInterface $translator, mixed $object, string $format = null, array $context = []): string
    {
        return $translator->trans($object);
    }
}
