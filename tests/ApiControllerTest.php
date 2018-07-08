<?php

namespace App\Framework\Tests;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use GuzzleHttp\Client;
/**
 * Class ApiControllerTest
 * @package App\Framework\Tests
 */
class ApiControllerTest extends TestCase
{

    public function testGetRecipe()
    {
        $client = new Client();
        $url = 'http://127.0.0.1:8000/api/v1/recipe/salt';
        $res = $client->request('GET', $url);
        $this->assertEquals(200, $res->getStatusCode());
    }

    public function testGetRecipeExampleScreenData()
    {
        $client = new Client();
        $url = 'http://127.0.0.1:8000/api/v1/recipeExample';
        $res = $client->request('GET', $url);
        $this->assertEquals(200, $res->getStatusCode());
    }
}