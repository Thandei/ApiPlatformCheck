<?php namespace App\ApiResource\Normalizer;

use App\Controller\Admin\Helpers\DatabaseTranslationController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class TranslatableTextNormalizer implements NormalizerInterface
{


    public function __construct(private TranslatorInterface $translator)
    {
    }

    public function normalize(mixed $object, string $format = null, array $context = []): string
    {
        return DatabaseTranslationController::apiPropertyNormalize($this->translator, $object, $format, $context);
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return DatabaseTranslationController::apiPropertySupportsNormalization($data, $format, $context);
    }
}