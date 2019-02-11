<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Universe;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UniverseController extends AbstractController
{
    /**
     * @Route("/universe/{idUniverse<\d+>}", name="universe_show")
     * 
     * Show a universe identified by its id
     * 
     * @param int $idUniverse Id of the universe
     */
    public function show(int $idUniverse) : Response
    {
        // Get the universe from the database 
        $universe = $this->getDoctrine()
            ->getRepository(Universe::class)
            ->find($idUniverse);

        // If the universe is null then it doesn't exist
        if (is_null($universe)) {
            throw $this->createNotFoundException('Not Found');
        }

        return $this->render('universe/show.html.twig', [
            'universe' => $universe,
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/universe/get/{order}/{afterDate?}", name="universe_get")
     * 
     * Returns a json formated string that contains all stories 
     * from a universe after a given date and with a specific order
     * 
     * @param string $order The type of order. It can be :
     *      - "update" : sort by last update 
     *      - "create" : sort by creation date 
     *      - "top" : sort by activity (number of message in this universe)
     * @param \DateTime $after (optional) Start date limit (inclusive)
     */
    public function getUniverses(string $order, ? \DateTime $afterDate)
    {
        // Get the top universes from the database 
        $topUniverses = $this->getDoctrine()
            ->getRepository(Universe::class)
            ->findUniversesAfterDateAndOrdered($order, $afterDate);

        return new JsonResponse(
            $topUniverses->map(function (Universe $universe) {
                return $universe->toJson();
            })->toArray()
        );
    }
}
