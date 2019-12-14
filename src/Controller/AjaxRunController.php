<?php


namespace App\Controller;

use App\Entity\Run;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        return new JsonResponse([$unfinished->getDateStarted()->format('Y-m-d H:i:s')], 200);
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

        return new JsonResponse([$unfinished->getDateStarted()->diff($unfinished->getDateEnded())], 200);
    }
}