<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Universe;
use Symfony\Component\HttpFoundation\JsonResponse;

class UniverseController extends AbstractController
{
    /**
     * @Route("/universe/{id}", name="universe")
     */
    public function show(int $id)
    {
        $universe = $this->getDoctrine()
            ->getRepository(Universe::class)
            ->find($id);

        if (is_null($universe)) 
        {
            throw $this->createNotFoundException('Not Found');
        }

        return $this->render('universe/show.html.twig', [
            'universe' => $universe,
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/universe/get/{order}/{afterDate?}", name="universe_get")
     */
    public function getUniverses(string $order, ?\DateTime $afterDate)
    {
        $topUniverses = $this->getDoctrine()
            ->getRepository(Universe::class)
            ->findUniversesAfterDateAndOrdered($order, $afterDate);

        return new JsonResponse(
            $topUniverses->map(function(Universe $universe) {
                return $universe->toJson();
            })->toArray()
        );
    }
}
