<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Location;
use App\Entity\Universe;

class LocationController extends AbstractController
{
    /**
     * @Route("/universe/{idUniverse}/location", methods={"GET"}, name="location")
     */
    public function index(int $idUniverse)
    {
        $universe = $this->getDoctrine()
            ->getRepository(Universe::class)
            ->find($idUniverse);

        if (is_null($universe)) {
            throw $this->createNotFoundException();
        }

        $locations = $this->getDoctrine()
            ->getRepository(Location::class)
            ->findBy([
                'universe' => $idUniverse,
                'parentLocation' => null
            ]);

        return $this->render('location/index.html.twig', [
            'universe' => $universe,
            'locations' => $locations,
            'user' => $this->getUser()
        ]);
    }
}
