<?php

declare(strict_types=1);

namespace SearchPlace;

use SearchPlace\Entity\SearchPlace;
use SearchPlace\Entity\SearchPlaceCollection;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zend\Expressive\Hal\Metadata\MetadataMap;
use Zend\Expressive\Hal\Metadata\RouteBasedCollectionMetadata;
use Zend\Expressive\Hal\Metadata\RouteBasedResourceMetadata;
use Zend\Hydrator\ReflectionHydrator;

/**
 * The configuration provider for the SearchPlace module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
            'doctrine'     => $this->getDoctrineEntities(),
            MetadataMap::class => $this->getHalMetadataMap(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'delegators' => [
                \Zend\Expressive\Application::class => [
                   RoutesDelegator::class,
                ],
            ],
            'invokables' => [
            ],
            'factories'  => [
                Handler\SearchPlaceReadHandler::class => Handler\SearchPlaceReadHandlerFactory::class,
                Handler\PlaceAddingHandler::class => Handler\PlaceAddingHandlerFactory::class,
                Handler\FindCandidateHandler::class => Handler\FindCandidateHandlerFactory::class
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'search-place'    => [__DIR__ . '/../templates/'],
            ],
        ];
    }

    public function getDoctrineEntities() : array
    {
        return [
            'driver' => [
                'orm_default' => [
                    'class' => MappingDriverChain::class,
                    'drivers' => [
                        'SearchPlace\Entity' => 'searchplace_entity',
                    ],
                ],
                'searchplace_entity' => [
                    'class' => AnnotationDriver::class,
                    'cache' => 'array',
                    'paths' => [__DIR__ . '/Entity'],
                ],
            ],
        ];
    }

    public function getHalMetadataMap()
    {
        return [
            [
                '__class__' => RouteBasedResourceMetadata::class,
                'resource_class' => SearchPlace::class,
                'route' => 'search.query',
                'extractor' => ReflectionHydrator::class,
            ],
            [
                '__class__' => RouteBasedCollectionMetadata::class,
                'collection_class' => SearchPlaceCollection::class,
                'collection_relation' => 'result',
                'route' => 'search.query',
            ],
        ];
    }
}