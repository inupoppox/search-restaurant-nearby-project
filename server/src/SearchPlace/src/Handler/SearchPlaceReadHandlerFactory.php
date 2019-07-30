<?php

declare(strict_types=1);

namespace SearchPlace\Handler;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;

class SearchPlaceReadHandlerFactory
{
    public function __invoke(ContainerInterface $container) : SearchPlaceReadHandler
    {
        $entityManager = $container->get(EntityManager::class);
        $resourceGenerator = $container->get(ResourceGenerator::class);
        $halResponseFactory = $container->get(HalResponseFactory::class);

        return new SearchPlaceReadHandler($entityManager,
            $container->get('config')['page_size'],
            $container->get('config')['key_api'],
            $resourceGenerator,
            $halResponseFactory);
    }
}
