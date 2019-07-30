<?php

declare(strict_types=1);

namespace SearchPlace\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class FindCandidateHandler implements RequestHandlerInterface
{
    protected $keyAPI;

    public function __construct($keyAPI)
    {
        $this->keyAPI = $keyAPI;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {

        $place_request = $request->getAttribute('place');
        $place_name = str_replace(' ', '+', $place_request);
        $APIUrl = 'https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input='.$place_name.'&inputtype=textquery&fields=id,name,geometry&key='.$this->keyAPI;

        $resp_json = file_get_contents($APIUrl);
        $resp = json_decode($resp_json, true);
        $result = array();

        if($resp['status'] == 'OK'){
            $result['id'] = $resp['candidates'][0]['id'];
            $result['name'] = $resp['candidates'][0]['name'];
            $result['lat'] = $resp['candidates'][0]['geometry']['location']['lat'];
            $result['lng'] = $resp['candidates'][0]['geometry']['location']['lng'];
            return new JsonResponse($result, 200);
        } else {
            $result['code_status'] = 400;
            $result['status'] = $resp['status'];
            $result['message'] = "No matching location found in Google Maps. Please try again";
            return new JsonResponse($result, 400);
        }
    }
}
