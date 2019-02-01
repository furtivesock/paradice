<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Universe;

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
        ]);
    }
}
