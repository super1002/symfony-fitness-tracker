<?php


namespace App\Controller;

use App\Entity\Run;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RunController
 * @Route("/run", name="run_")
 */
class RunController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    public function listRuns()
    {
        $runs = $this->getDoctrine()->getRepository(Run::class)->findAll();

        return $this->render('runs/list-runs.html.twig', ['runs' => $runs]);
    }
}