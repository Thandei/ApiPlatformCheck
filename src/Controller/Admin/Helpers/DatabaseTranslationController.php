<?php

namespace App\Controller\Admin\Helpers;

use App\Controller\Admin\AdminBaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/admin', name: 'app_admin_')]
class DatabaseTranslationController extends AdminBaseController
{

    const TRANSLATION_ATTRIBUTES = ["appName", "name"];
    const TRANSLATION_PREFIX = 'app.database.';

    #[Route('/database/translation', name: 'database_translation')]
    public function index(): Response
    {
        return $this->render('database_translation/index.html.twig', [
            'controller_name' => 'DatabaseTranslationController',
        ]);
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
