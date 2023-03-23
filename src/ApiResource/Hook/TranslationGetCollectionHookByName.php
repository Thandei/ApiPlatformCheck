<?php

namespace App\ApiResource\Hook;

use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class TranslationGetCollectionHookByName implements ProviderInterface
{
    public function __construct(private readonly CollectionProvider $itemProvider, private readonly TranslatorInterface $translator)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {

        $myPrevItems = $this->itemProvider->provide($operation, $uriVariables, $context);
        return $this->translateProvidedItemsByName($myPrevItems);
    }

    public function translateProvidedItemsByName($providedItems)
    {
        foreach ($providedItems as $myPrevItem) {
            $myPrevItem->setName($this->translator->trans($myPrevItem->getName()));
        }

        return $providedItems;
    }
}