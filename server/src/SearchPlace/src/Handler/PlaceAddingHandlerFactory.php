<?php

declare(strict_types=1);

namespace SearchPlace\Handler;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;

class PlaceAddingHandlerFactory
{
    public function __invoke(ContainerInterface $container) : PlaceAddingHandler
    {
        return new PlaceAddingHandler(
            $container->get(EntityManager::class),
            $container->get(HalResponseFactory::class),
            $container->get(ResourceGenerator::class)
        );
    }
}
