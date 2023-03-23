<?php namespace App\ApiResource\Normalizer;

use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class TranslationNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{

    const TRANSLATION_ENDFIX = '|trans';

    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    public function normalize(mixed $object, string $format = null, array $context = []): string
    {
        return $this->translator->trans(str_replace(self::TRANSLATION_ENDFIX, '', $object));
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        if (is_string($data)) {
            if (str_ends_with($data, self::TRANSLATION_ENDFIX)) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return TRUE;
    }
}