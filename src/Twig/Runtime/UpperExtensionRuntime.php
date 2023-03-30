<?php

namespace App\Twig\Runtime;

use Symfony\Component\String\UnicodeString;
use Twig\Extension\RuntimeExtensionInterface;

class UpperExtensionRuntime implements RuntimeExtensionInterface
{

    const oldChars = ["i", "ç", "ş", "ü", "ğ", "ı"];
    const newChars = ["İ", "Ç", "Ş", "Ü", "Ğ", "I"];

    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function upperx($value): string
    {
        $newCasedString = str_replace(self::oldChars, self::newChars, $value);
        $myUC = new UnicodeString($newCasedString);
        return $myUC->upper();
    }
}
