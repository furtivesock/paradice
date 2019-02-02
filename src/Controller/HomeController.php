<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Universe;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController extends AbstractController
{
    private const NB_TOP = 5;

    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        $today = new \DateTime();
        $oneDay = new \DateInterval("P1D");
        $oneWeek = new \DateInterval("P1W");
        $oneMonth = new \DateInterval("P1M");

        $topUniversesDay = $this->getDoctrine()
            ->getRepository(Universe::class)
            ->findTopUniversesAfterDate($today->sub($oneDay), self::NB_TOP);
        
        $topUniversesWeek = $this->getDoctrine()
            ->getRepository(Universe::class)
            ->findTopUniversesAfterDate($today->sub($oneWeek), self::NB_TOP);

        $topUniversesMonth = $this->getDoctrine()
            ->getRepository(Universe::class)
            ->findTopUniversesAfterDate($today->sub($oneMonth), self::NB_TOP);
        
        return $this->render('home/index.html.twig', [
            'topUniversesDay' => $topUniversesDay,
            'topUniversesWeek' => $topUniversesWeek,
            'topUniversesMonth' => $topUniversesMonth,
            'user' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/home/top/{afterDate}", name="home_top")
     */
    public function topStoriesJson(\DateTime $afterDate)
    {
        $topUniverses = $this->getDoctrine()
            ->getRepository(Universe::class)
            ->findTopUniversesAfterDate($afterDate, self::NB_TOP);

        return new JsonResponse(
            $topUniverses->map(function(Universe $universe) {
                return $universe->toJson();
            })->toArray()
        );
    }
}
