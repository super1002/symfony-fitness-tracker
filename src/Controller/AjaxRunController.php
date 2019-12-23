<?php


namespace App\Controller;

use App\Entity\JoggingRoute;
use App\Entity\Run;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RunController
 * @Route("/ajax/run", name="ajax_run_")
 */
class AjaxRunController extends AbstractController
{
    /**
     * @Route("/start", name="start")
     */
    public function startRunning()
    {
        $run = new Run();
        $run->setDateStarted(new DateTime());
        $em = $this->getDoctrine()->getManager();
        $em->persist($run);
        $em->flush();

        return new JsonResponse(['message' => 'Successfully started timer', 'date_started' => $run->getDateStarted()->format('Y-m-d h:i:s')], 201);
    }

    /**
     * @Route("/load-current", name="load_current")
     */
    public function loadCurrentRun()
    {
        $unfinished = $this->getDoctrine()->getRepository(Run::class)->findOneBy(['dateEnded' => null]);

        $routeId = $unfinished->getRoute() ? $unfinished->getRoute()->getId() : 0;

        return new JsonResponse(['current' => $unfinished->getDateStarted()->format('Y-m-d H:i:s'), 'route' => $routeId], 200);
    }

    /**
     * @Route("/stop", name="stop")
     * @return JsonResponse
     * @throws Exception
     */
    public function stopRunning()
    {
        $unfinished = $this->getDoctrine()->getRepository(Run::class)->findOneBy(['dateEnded' => null]);
        $unfinished->setDateEnded(new DateTime());
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse([$unfinished->getDateStarted()->diff($unfinished->getDateEnded())], 200);
    }

    /**
     * @Route("/set-route", name="set_route")
     * @param Request $request
     * @return JsonResponse
     */
    public function setRoute(Request $request)
    {
        if (!$request->query->has('routeId')) {
            return new JsonResponse([], 400);
        }

        if ($request->query->get('routeId') === 0) {
            return new JsonResponse([]);
        }

        $route = $this->getDoctrine()->getRepository(JoggingRoute::class)->findOneBy(['id' => $request->query->get('routeId')]);

        if (!$route) {
            return new JsonResponse([], 404);
        }

        $currentRun = $this->getDoctrine()->getRepository(Run::class)->findOneBy(['dateEnded' => null]);

        if (!$currentRun) {
            return new JsonResponse(['message' => 'No Run defined']);
        }

        $currentRun->setRoute($route);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse([]);
    }
}