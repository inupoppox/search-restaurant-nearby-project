<?php

declare(strict_types=1);

namespace SearchPlace\Handler;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use SearchPlace\Entity\SearchPlace;
use Zend\Diactoros\Response\JsonResponse;

class SearchSinglePlaceHandler implements RequestHandlerInterface
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $result = array();
        $restaurantID = $request->getAttribute('id');
        $repository = $this->entityManager->getRepository(SearchPlace::class);
        $query = $repository
            -> createQueryBuilder('a')
            ->where('a.id = '.$restaurantID)
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);

        try {
            $result['status'] = "OK";
            $result['result'] = $query;
            return new JsonResponse($result, 200);
        } catch (\Exception $e) {
            return new JsonResponse($result, 400);
        }
    }
}
