<?php

namespace SearchPlace;

use SearchPlace\Handler;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;

class RoutesDelegator
{
    /**
     * @param ContainerInterface $container
     * @param string $serviceName Name of the service being created.
     * @param callable $callback Creates and returns the service.
     * @return Application
     */
    public function __invoke(ContainerInterface $container, $serviceName, callable $callback)
    {
        /** @var $app Application */
        $app = $callback();
        header("Access-Control-Allow-Origin: *");
        // Setup routes:
        $app->get('/findcand/{place}[/]', Handler\FindCandidateHandler::class, 'search.candidate');
        $app->get('/search/{place}/{lati}/{longi}[/]', Handler\SearchPlaceReadHandler::class, 'search.query');
        $app->get('/placedetail/{id}[/]', Handler\SearchSinglePlaceHandler::class, 'search.single');
        return $app;
    }
}