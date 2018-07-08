<?php

namespace App\Framework\Service;

use GuzzleHttp\Client;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RenderRecipeResult
 * @package App\Framework\Service
 */
class RenderRecipeResult
{

    /** @var SerializerInterface $serializer */
    private $serializer;
    /** @var Client $client */
    private $client;
    /** @var array|false|string $uri */
    private $uri;
    /** @var  $response */
    private $response;
    /** @var int $code */
    private $code;
    /** @var string $message */
    private $message;
    /** @var bool $error */
    private $error;

    /**
     * RenderRecipeResult constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
        $this->client = new Client();
        $this->uri = getenv('RECIPEPUPPY_API_URL');
        $this->response = '';
        $this->code = 200;
        $this->message = '';
        $this->error = false;
    }

    /**
     * @param string $ingredient
     * @param string $query
     * @param int $page
     * @return Response
     */
    public function renderResult(string $ingredient, string $query, int $page): Response
    {
        $data = '';
        try {
            $this->response = $this->querySearch($ingredient, $query, $page);

            $data = json_decode($this->response->getBody()->getContents(), true);
            if (empty($data['results'])) {
                $this->message = 'No hay resultados';
            }

        } catch (Exception $e) {
            $this->message = $e->getMessage();
        }

        $responseData = array(
            'statusCode' => $this->response->getStatusCode(),
            'status' => $this->response->getReasonPhrase(),
            'messageError' => $this->message,
            'data' => $data['results'],
        );

        return new Response($this->serializer->serialize($responseData, 'json'));
    }

    /**
     * @param string $ingredient
     * @param string $query
     * @param int $page
     * @return mixed
     */
    private function querySearch(string $ingredient, string $query, int $page = 1)
    {
        $response = $this->client->request(
            'GET',
            $this->uri.'?i='.$ingredient.
            '&q='.$query.
            '&p='.$page);

        return $response;
    }

}