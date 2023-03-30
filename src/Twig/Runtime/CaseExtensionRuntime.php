<?php

namespace App\Twig\Runtime;

use Symfony\Component\String\UnicodeString;
use Twig\Extension\RuntimeExtensionInterface;

class CaseExtensionRuntime implements RuntimeExtensionInterface
{

    public const BROKEN_CHARACTERS_LOWERCASE = ["ç", "ö", "ı", "ş", "ğ", "ü", "i"];
    public const FIXED_CHARACTERS_UPPERCASE = ["Ç", "Ö", "I", "Ş", "Ğ", "Ü", "İ"];

    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function caseUpper($value): string
    {
        $fixedString = str_replace(self::BROKEN_CHARACTERS_LOWERCASE, self::FIXED_CHARACTERS_UPPERCASE, $value);
        $myUnicodeString = new UnicodeString($fixedString);
        return $myUnicodeString->upper();
    }

    public function caseLower($value): string
    {
        $fixedString = str_replace(self::FIXED_CHARACTERS_UPPERCASE, self::BROKEN_CHARACTERS_LOWERCASE, $value);
        $myUnicodeString = new UnicodeString($fixedString);
        return $myUnicodeString->lower();

    }
}
