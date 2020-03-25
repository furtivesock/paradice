<?php

namespace App\Controller;

use App\Entity\Universe;
use App\Entity\UniverseApplication;
use App\Entity\UniverseMember;
use App\Form\UniverseApplicationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class UniverseApplicationController extends AbstractController
{
    /**
     * @Route("/universe/{idUniverse<\d+>}/application", name="universe_application")
     */
    public function index(int $idUniverse): Response
    {
        $universe = $this->getDoctrine()
            ->getRepository(Universe::class)
            ->find($idUniverse);

        if (is_null($universe)) {
            throw $this->createNotFoundException('Not Found');
        }

        if (is_null($this->getUser())) {
            throw $this->createAccessDeniedException('Access Denied.');
        }

        if (!$universe->isCreator($this->getUser()) && !$universe->isModerator($this->getUser())) {
            throw $this->createAccessDeniedException('Access Denied.');
        }

        return $this->render('universe_application/index.html.twig', [
            'universe' => $universe,
            'user'     => $this->getUser(),
        ]);
    }

    /**
     * @Route("/universe/{idUniverse<\d+>}/application/get", name="universe_application_get")
     */
    public function getAll(int $idUniverse): JsonResponse
    {
        $universe = $this->getDoctrine()
            ->getRepository(Universe::class)
            ->find($idUniverse);

        if (is_null($universe)) {
            throw $this->createNotFoundException('Not Found');
        }

        if (is_null($this->getUser())) {
            throw $this->createAccessDeniedException('Access Denied.');
        }

        if (!$universe->isCreator($this->getUser()) && !$universe->isModerator($this->getUser())) {
            throw $this->createAccessDeniedException('Access Denied.');
        }

        $applications = $this->getDoctrine()
            ->getRepository(UniverseApplication::class)
            ->findBy([
                'universe' => $idUniverse,
            ]);

        return new JsonResponse(
            array_map(function (UniverseApplication $uApplication) {
                return $uApplication->toJson();
            }, $applications)
        );
    }

    /**
     * @Route("/universe/{idUniverse<\d+>}/application/create", methods={"POST"}, name="universe_application_create")
     */
    public function create(int $idUniverse, Request $request): Response
    {
        $universe = $this->getDoctrine()
            ->getRepository(Universe::class)
            ->find($idUniverse);

        if (is_null($universe)) {
            throw $this->createNotFoundException('Not Found');
        }

        if (is_null($this->getUser())) {
            throw $this->createAccessDeniedException('Access Denied.');
        }

        if ($universe->isApplicant($this->getUser())) {
            $this->addFlash('ERROR', 'Vous ne pouvez pas vous inscrire 2 fois pour le même univers !');

            return $this->redirectToRoute('universe_show', [
                'idUniverse' => $universe->getId(),
                'user'       => $this->getUser(),
            ]);
        }

        if (
            $universe->isMember($this->getUser()) ||
            $universe->isCreator($this->getUser()) ||
            $universe->isModerator($this->getUser())
        ) {
            $this->addFlash('ERROR', 'Vous êtes déjà member de cet univers !');

            return $this->redirectToRoute('universe_show', [
                'idUniverse' => $universe->getId(),
                'user'       => $this->getUser(),
            ]);
        }

        $application = new UniverseApplication();

        // Build the form
        $form = $this->createForm(
            UniverseApplicationFormType::class,
            $application,
            [
                'action' => $this->generateUrl('universe_application_create', ['idUniverse' => $idUniverse]),
            ]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $application = $form->getData();

            $application->setApplicant($this->getUser());
            $application->setUniverse($universe);
            $application->setMotivation(trim($application->getMotivation()));
            $application->setApplicationDate(new \DateTime('now', new \DateTimeZone('UTC')));
            $application->setAccepted(null);

            // Insert the new application in the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($application);
            $entityManager->flush();

            return $this->redirectToRoute('universe_show', [
                'idUniverse' => $universe->getId(),
                'user'       => $this->getUser(),
            ]);
        }

        return $this->render('universe_application/new.html.twig', [
            'newApplicationForm' => $form->createView(),
            'universe'           => $universe,
            'user'               => $this->getUser(),
        ]);
    }

    /**
     * @Route("/universe/{idUniverse<\d+>}/application/new", methods={"GET"}, name="universe_application_new")
     */
    public function new(
        int $idUniverse
    ): Response {
        $universe = $this->getDoctrine()
            ->getRepository(Universe::class)
            ->find($idUniverse);

        if (is_null($universe)) {
            throw $this->createNotFoundException('Not Found');
        }

        if (is_null($this->getUser())) {
            throw $this->createAccessDeniedException('Access Denied.');
        }

        if ($universe->isApplicant($this->getUser())) {
            $this->addFlash('ERROR', 'Vous ne pouvez pas vous inscrire 2 fois pour le même univers !');

            return $this->redirectToRoute('universe_show', [
                'idUniverse' => $universe->getId(),
                'user'       => $this->getUser(),
            ]);
        }

        if (
            $universe->isMember($this->getUser()) ||
            $universe->isCreator($this->getUser()) ||
            $universe->isModerator($this->getUser())
        ) {
            $this->addFlash('ERROR', 'Vous êtes déjà member de cet univers !');

            return $this->redirectToRoute('universe_show', [
                'idUniverse' => $universe->getId(),
                'user'       => $this->getUser(),
            ]);
        }

        $application = new UniverseApplication();

        // Build the form
        $form = $this->createForm(
            UniverseApplicationFormType::class,
            $application,
            [
                'action' => $this->generateUrl('universe_application_create', ['idUniverse' => $idUniverse]),
            ]
        );

        return $this->render('universe_application/new.html.twig', [
            'newApplicationForm' => $form->createView(),
            'universe'           => $universe,
            'user'               => $this->getUser(),
        ]);
    }

    /**
     * @Route("/universe/{idUniverse<\d+>}/application/{idApplicant<\d+>}/accept", methods={"POST"}, name="universe_application_accept")
     */
    public function accept(
        int $idUniverse,
        int $idApplicant,
        Request $request
    ): JsonResponse {
        $universe = $this->getDoctrine()
            ->getRepository(Universe::class)
            ->find($idUniverse);

        if (is_null($universe)) {
            throw $this->createNotFoundException('Universe Not Found');
        }

        $application = $this->getDoctrine()
            ->getRepository(UniverseApplication::class)
            ->findOneBy([
                'universe'  => $idUniverse,
                'applicant' => $idApplicant,
            ]);

        if (is_null($application)) {
            throw $this->createNotFoundException('Application Not Found');
        }

        if (is_null($this->getUser())) {
            throw $this->createAccessDeniedException('Access Denied.');
        }

        if (!$universe->isCreator($this->getUser()) && !$universe->isModerator($this->getUser())) {
            throw $this->createAccessDeniedException('Access Denied.');
        }

        if (
            $universe->isMember($application->getApplicant()) ||
            $universe->isCreator($application->getApplicant()) ||
            $universe->isModerator($application->getApplicant())
        ) {
            throw new BadRequestHttpException('Applicant is already a member');
        }

        // Get post data
        $post_data = json_decode($request->getContent(), true);

        if (!array_key_exists('accept', $post_data) || !is_bool($post_data['accept'])) {
            throw new BadRequestHttpException('Bad Request');
        }

        $entityManager = $this->getDoctrine()->getManager();

        if ($post_data['accept']) {
            $application->setAccepted(true);

            $uMember = new UniverseMember();
            $uMember->setMember($application->getApplicant());
            $uMember->setUniverse($application->getUniverse());
            $uMember->setAcceptationDate(new \DateTime('now', new \DateTimeZone('UTC')));

            $entityManager->persist($uMember);
        } else {
            $application->setAccepted(false);
        }

        $entityManager->persist($application);
        $entityManager->flush();

        return new JsonResponse();
    }
}
