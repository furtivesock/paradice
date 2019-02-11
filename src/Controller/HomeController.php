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
     * @Route("/", name="home")
     *
     */
    public function index() : Response
    {
        return $this->render('home/index.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
}
