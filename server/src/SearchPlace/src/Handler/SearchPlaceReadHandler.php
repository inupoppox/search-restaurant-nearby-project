<?php

declare(strict_types=1);

namespace SearchPlace\Handler;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use SearchPlace\Entity\SearchPlace;
use SearchPlace\Entity\SearchPlaceCollection;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;

class SearchPlaceReadHandler implements RequestHandlerInterface
{
    protected $entityManager;
    protected $pageCount;
    protected $keyAPI;
    protected $resourceGenerator;
    protected $halResponseFactory;

    public function __construct(EntityManager $entityManager, $pageCount, $keyAPI,
                                ResourceGenerator $resourceGenerator,
                                HalResponseFactory $halResponseFactory)
    {
        $this->entityManager = $entityManager;
        $this->pageCount = $pageCount;
        $this->keyAPI = $keyAPI;
        $this->resourceGenerator = $resourceGenerator;
        $this->halResponseFactory = $halResponseFactory;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {

        $placeID = $request->getAttribute('place');
        $latitude = $request->getAttribute('lati');
        $longtitude = $request->getAttribute('longi');
        $repository = $this->entityManager->getRepository(SearchPlace::class);
        $query = $repository
            -> createQueryBuilder('a')
            ->addOrderBy('a.id', 'asc')
            ->setMaxResults($this->pageCount)
            ->where('a.placeID LIKE :word')
            ->setParameter('word', '%'.$placeID.'%')
            ->getQuery();

        $paginator = new SearchPlaceCollection($query);

        if (count($paginator) < 1){
            $APIUrl = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location='
                .$latitude.','.$longtitude.'&radius=500&types=restaurant&key='.$this->keyAPI;
            $resp_json = file_get_contents($APIUrl);
            $resp = json_decode($resp_json, true);

            if($resp['status'] == 'OK'){
                foreach ($resp['results'] as &$value) {
                    $entity = new SearchPlace();
                    $result = array();

                    // Set value to result object
                    $result['placeID'] = $placeID;
                    $result['name'] = isset($value['name']) ? $value['name'] : "No Name";
                    $result['lati'] = isset($value['geometry']['location']['lat']) ?
                        strval($value['geometry']['location']['lat']) : "";
                    $result['longi'] = isset($value['geometry']['location']['lng']) ?
                        strval($value['geometry']['location']['lng']) : "";
                    $result['vicinity'] = isset($value['vicinity']) ? $value['vicinity'] : "No Information";
                    $result['photos'] = isset($value['photos'][0]['photo_reference']) ?
                        $value['photos'][0]['photo_reference'] : "";
                    $result['rating'] = isset($value['rating']) ? intval($value['rating']) : 0;

                    // Verify if data is complete
                    if($result['name'] && $result['lati'] && $result['longi'])
                    {
                        try {
                            $entity->setPlaceToDatabase($result);
                            $this->entityManager->persist($entity);
                            $this->entityManager->flush();
                        } catch (ORMException $e) {
                            $result['_error']['error'] = 'not_created';
                            $result['_error']['error_description'] = $e->getMessage();
                            return new JsonResponse($result, 400);
                        }
                    }
                }
            }
            else {
                $result['code_status'] = 400;
                $result['status'] = $resp['status'];
                return new JsonResponse($result, 400);
            }

            $query = $repository
                -> createQueryBuilder('a')
                ->addOrderBy('a.id', 'asc')
                ->setMaxResults($this->pageCount)
                ->where('a.placeID LIKE :word')
                ->setParameter('word', '%'.$placeID.'%')
                ->getQuery();
            $paginator = new SearchPlaceCollection($query);

        }

        $resource = $this->resourceGenerator->fromObject($paginator, $request);

        return $this->halResponseFactory->createResponse($request, $resource);
    }
}
