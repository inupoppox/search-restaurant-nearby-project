<?php

declare(strict_types=1);

namespace SearchPlace\Handler;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use SearchPlace\Entity\SearchPlace;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;

class PlaceAddingHandler implements RequestHandlerInterface
{
    protected $entityManager;
    protected $halResponseFactory;
    protected $resourceGenerator;

    public function __construct(EntityManager $entityManager,
                                HalResponseFactory $halResponseFactory,
                                ResourceGenerator $resourceGenerator)
    {
        $this->entityManager = $entityManager;
        $this->halResponseFactory = $halResponseFactory;
        $this->resourceGenerator = $resourceGenerator;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        // Create and return a response
        $requestBody = $request->getParsedBody()['Request']['PlaceDetail'];

        if (empty($requestBody)) {
            $result['_error']['error'] = 'missing_request';
            $result['_error']['error_description'] = 'No request body sent.';

            return new JsonResponse($result, 400);
        }

        $entity = new SearchPlace();

        try {
            $entity->setPlaceToDatabase($requestBody);
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
            $result['status'] = "OK";
        } catch (ORMException $e) {
            $result['_error']['error'] = 'not_created';
            $result['_error']['error_description'] = $e->getMessage();

            return new JsonResponse($result, 400);
        }

        return new JsonResponse($result, 200);
    }
}
