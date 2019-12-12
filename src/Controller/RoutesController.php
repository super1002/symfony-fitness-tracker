<?php


namespace App\Controller;

use App\Entity\JoggingRoute;
use App\Form\JoggingRouteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RoutesController
 * @Route("/routes", name="routes_")
 */
class RoutesController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @return RedirectResponse
     */
    public function index()
    {
        return $this->redirectToRoute('routes_list');
    }

    /**
     * @Route("/list", name="list")
     * @return Response
     */
    public function listRoutes()
    {
        $routes = $this->getDoctrine()->getRepository(JoggingRoute::class)->findAll();

        return $this->render('routes/list-routes.html.twig', [
            'joggingRoutes' => $routes,
        ]);
    }

    /**
     * @Route("/add", name="add")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function addRoute(Request $request)
    {
        $form = $this->createForm(JoggingRouteType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();

            return $this->redirectToRoute('routes_list');
        }

        return $this->render('base/add.html.twig', [
            'title' => 'Joggin Route',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{route}", name="edit")
     * @param Request $request
     * @param JoggingRoute $route
     * @return RedirectResponse|Response
     */
    public function editRoute(Request $request, JoggingRoute $route)
    {
        $form = $this->createForm(JoggingRouteType::class, $route);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();

            return $this->redirectToRoute('routes_list');
        }

        return $this->render('base/add.html.twig', [
            'title' => 'Joggin Route',
            'form' => $form->createView(),
        ]);
    }
}