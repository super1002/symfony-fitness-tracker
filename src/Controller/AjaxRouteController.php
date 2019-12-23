<?php


namespace App\Controller;

use App\Entity\JoggingRoute;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AjaxRouteController
 * @Route("/ajax/route", name="ajax_route_")
 */
class AjaxRouteController extends AbstractController
{
    /**
     * @Route("/load", name="load")
     */
    public function loadRoutes()
    {
        $routes = $this->getDoctrine()->getRepository(JoggingRoute::class)->findAll();

        $ret = [];
        foreach ($routes as $route) {
            array_push($ret, $route->toArray());
        }

        return new JsonResponse($ret);
    }
}