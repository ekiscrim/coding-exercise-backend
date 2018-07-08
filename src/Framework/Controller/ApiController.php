<?php

namespace App\Framework\Controller;

use App\Framework\Service\RenderRecipeResult;
use FOS\RestBundle\Controller\Annotations as REST;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request as Request;

/**
 * Class ApiController
 * @Route("/api")
 * @package App\Framework\Controller
 */
class ApiController extends Controller
{
    /**
     * @REST\Get("/v1/recipe/{ingredient}/{query}/{page}.{_format}",
     *     name="get_recipe",
     *     defaults={"ingredient": "", "query": "", "page": "1", "_format":"json",})
     */
    public function searchRecipeAction(Request $request, string $ingredient, string $query, int $page): Response
    {
        /** @var RenderRecipeResult $renderService */
        $renderService = $this->get('render_recipe_result');
        $result = $renderService->renderResult($ingredient, $query, $page);
        return $result;
    }

    /**
     * @REST\Get("/v1/recipeExample/.{_format}",
     *     name="recipe_example_screen",
     *     defaults={"_format":"json",})
     */
    public function searchSampleScreen(Request $request)
    {
        $ingredient = '';
        $querySearch = 'vegetarian';
        $page = 1;
        /** @var RenderRecipeResult $renderService */
        $renderService = $this->get('render_recipe_result');
        return $renderService->renderResult($ingredient, $querySearch, $page);
    }
}