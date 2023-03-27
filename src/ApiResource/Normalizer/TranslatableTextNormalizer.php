<?php namespace App\ApiResource\Normalizer;

use App\Controller\Admin\Helpers\DatabaseTranslationController;
use Exception;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class TranslatableTextNormalizer implements NormalizerInterface
{

    const ALLOW_REMAKING_DATABASE_TRANSLATIONS = TRUE;

    public function __construct(private TranslatorInterface $translator, private string $projectDir)
    {
    }

    public function normalize(mixed $object, string $format = null, array $context = []): string
    {

        if (self::ALLOW_REMAKING_DATABASE_TRANSLATIONS) {
            $this->addDatabaseTranslationKeyToFile($object);
        }

        return DatabaseTranslationController::apiPropertyNormalize($this->translator, $object, $format, $context);
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return DatabaseTranslationController::apiPropertySupportsNormalization($data, $format, $context);
    }

    private function addDatabaseTranslationKeyToFile(string $databaseTranslationKey): void
    {
        $translationsFile = $this->projectDir . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'raw' . DIRECTORY_SEPARATOR . 'database_translations.html.twig';
        if (file_exists($translationsFile)) {
            $rawContent = file_get_contents($translationsFile);
            $explodedTranslationsContent = explode(PHP_EOL, $rawContent);
            $explodedTranslationsContent[] = "{{ '" . $databaseTranslationKey . "'|trans }}";
            file_put_contents($translationsFile, implode(PHP_EOL, $this->removeEmptyLines($explodedTranslationsContent)));
        }

    }

    private function removeEmptyLines(array $databaseTranslationFileLines): array
    {
        foreach ($databaseTranslationFileLines as $index => $databaseTranslationFileLine) {

            if (($databaseTranslationFileLine === PHP_EOL) or (strlen($databaseTranslationFileLine) < 5)) {
                unset($databaseTranslationFileLines[$index]);
            }

        }
        return array_unique($databaseTranslationFileLines);
    }

}