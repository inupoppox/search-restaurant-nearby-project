<?php

declare(strict_types=1);

namespace SearchPlace\Handler;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class SearchSinglePlaceHandlerFactory
{
    public function __invoke(ContainerInterface $container) : SearchSinglePlaceHandler
    {
        $entityManager = $container->get(EntityManager::class);

        return new SearchSinglePlaceHandler($entityManager);
    }
}
