<?php

namespace App\Framework\Controller;

use GuzzleHttp\Psr7\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Client;

/**
 * Class IndexController
 * @package App\Framework\Controller
 */
class IndexController extends Controller
{
    const BASE_URI = 'http://www.recipepuppy.com/';
    /**
     * @Route("/", name="")
     */
    public function indexAction(): Response
    {
       return new Response('hello world');
    }

    /**
     * @param Request $request
     * @Route("/search", name="search_recipe")
     * @return JsonResponse
     */
    public function searchAction(\Symfony\Component\HttpFoundation\Request $request): JsonResponse
    {
        $params = array(
            'ingredients' => $request->get('ingredients'),
            'query' => $request->get('query'),
            'page' => $request->get('page') ?? 1
        );

        /** @var Client $client */
        $client   = new Client(['base_uri' => self::BASE_URI,
            ['http_errors' => false]]);

        $response = json_decode(
            $client->request('GET',
                '/api/?i='.$params['ingredients'].
                '&q='.$params['query'].
                '&p='.$params['page']
            )->getBody(), true);

        return new JsonResponse($response);
    }
}