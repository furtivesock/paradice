<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\UniverseApplication;
use App\Form\UniverseApplicationFormType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Universe;

class UniverseApplicationController extends AbstractController
{
    /**
     * @Route("/universe/{idUniverse<\d+>}/application", name="universe_application")
     */
    public function index(int $idUniverse) : Response
    {
        $universe = $this->getDoctrine()
            ->getRepository(Universe::class)
            ->find($idUniverse);

        if (is_null($universe)) {
            throw $this->createNotFoundException('Not Found');
        }

        if (!$universe->isCreator($this->getUser()) || !$universe->isModerator($this->getUser())) {
            throw $this->createAccessDeniedException('Access Denied.');
        }

        $applications = $this->getDoctrine()
            ->getRepository(UniverseApplication::class)
            ->findBy(array(
                'universe' => $idUniverse
            ));

        return $this->render('universe_application/index.html.twig', [
            'applications' => $applications,
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/universe/{idUniverse<\d+>}/application/{idApplication<\d+>}", name="universe_application_show")
     */
    public function show(int $idUniverse, int $idApplication) : Response
    {
        $universe = $this->getDoctrine()
            ->getRepository(Universe::class)
            ->find($idUniverse);

        if (is_null($universe)) {
            throw $this->createNotFoundException('Not Found');
        }

        if (!$universe->isCreator($this->getUser()) || !$universe->isModerator($this->getUser())) {
            throw $this->createAccessDeniedException('Access Denied.');
        }

        $application = $this->getDoctrine()
            ->getRepository(UniverseApplication::class)
            ->findBy(array(
                'id' => $idApplication,
                'universe' => $idUniverse
            ));

        if (is_null($application)) {
            throw $this->createNotFoundException('Not Found');
        }

        return $this->render('universe_application/show.html.twig', [
            'application' => $application,
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/universe/{idUniverse<\d+>}/application/new", name="universe_application_new")
     */
    public function create(int $idUniverse, Request $request) : Response
    {
        $universe = $this->getDoctrine()
            ->getRepository(Universe::class)
            ->find($idUniverse);

        if (is_null($universe)) {
            throw $this->createNotFoundException('Not Found');
        }

        if (!$universe->isCreator($this->getUser()) || !$universe->isModerator($this->getUser())) {
            throw $this->createAccessDeniedException('Access Denied.');
        }

        $application = new UniverseApplication();

        // Build the form 
        $form = $this->createForm(
            UniverseApplicationFormType::class,
            $application
        );

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $application = $form->getData();


            $application->setApplicant($this->getUser());
            $application->setUniverse($universe);
            $application->setMotivation(trim($application->getMotivation()));
            $application->setApplicationDate(new \DateTime('now', new \DateTimeZone('UTC')));
            $application->setAccepted(null);

            // Insert the new chapter in the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($application);
            $entityManager->flush();

            return $this->redirectToRoute('universe_application', [
                'idUniverse' => $story->getUniverse()->getId(),
                'user' => $this->getUser()
            ]);
        }

        return $this->render('universe_application/new.html.twig', [
            'newApplicationForm' => $form->createView(),
            'user' => $this->getUser()
        ]);
    }
}
