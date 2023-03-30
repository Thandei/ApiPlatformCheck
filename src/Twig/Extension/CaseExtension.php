<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\CaseExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CaseExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('caseupper', [CaseExtensionRuntime::class, 'caseUpper']),
            new TwigFilter('caselower', [CaseExtensionRuntime::class, 'caseLower']),

        ];
    }

}
