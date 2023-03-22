<?php

namespace App\ApiResource\Hook;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class TranslationGetHookByName implements ProviderInterface
{
    public function __construct(private readonly ProviderInterface $itemProvider, private readonly TranslatorInterface $translator)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $myPrevItem = $this->itemProvider->provide($operation, $uriVariables, $context);
        $myPrevItem->setName($this->translator->trans($myPrevItem->getName()));
        return $myPrevItem;
    }
}