<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Universe;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CreateUniverseFormType;

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
            ->findAfterWithOrder($order, $afterDate);

        return new JsonResponse(
            $topUniverses->map(function (Universe $universe) {
                return $universe->toJson();
            })->toArray()
        );
    }

    /**
     * @Route("/universe/create", name="universe_create", methods={"POST"})
     * 
     * POST : Insert the new unviverse in the database
     * 
     * @param Request $request Request object to collect and use POST data
     */
    public function create(Request $request) : Response
    {    
        // Check if the user is a member of this universe
        if (is_null($this->getUser())) {
            return $this->createAccessDeniedException('You lust bo logged in to create universe.');
        }

        $universe = new Universe();

        // Build the form
        $form = $this->createForm(CreateUniverseFormType::class, $universe, array(
            'action' => $this->generateUrl('universe_create')
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $universe = $form->getData();

            // Insert the new story in the database 

            $entityManager = $this->getDoctrine()->getManager();

            $universe->setName(trim($universe->getName()));
            $universe->setDescription(trim($universe->getDescription()));
            $universe->setCreator($this->getUser());
            $universe->setCreationDate(new \DateTime('now', new \DateTimeZone('UTC')));

            $entityManager->persist($universe);
            $entityManager->flush();

            return $this->redirectToRoute('universe_show', [
                'idUniverse' => $universe->getId(),
                'user' => $this->getUser()
            ]);
        }

        return $this->render('universe/new.html.twig', [
            'newUniverseForm' => $form->createView(),
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/universe/new", name="universe_new", methods={"GET"})
     * 
     * GET : Show a form to create a new universe
     */
    public function new()
    {
        // Check if the user is a member of this universe
        if (is_null($this->getUser())) {
            return $this->createAccessDeniedException('You lust bo logged in to create universe.');
        }

        $universe = new Universe();

        // Build the form
        $form = $this->createForm(CreateUniverseFormType::class, $universe, array(
            'action' => $this->generateUrl('universe_create')
        ));


        return $this->render('universe/new.html.twig', [
            'newUniverseForm' => $form->createView(),
            'user' => $this->getUser()
        ]);
    }
}
