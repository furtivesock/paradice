<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Location;
use App\Entity\Universe;
use App\Form\CreateLocationFormType;
use Symfony\Component\HttpFoundation\Request;
use App\Service\FileUploaderService;

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

    /**
     * @Route("/universe/{idUniverse}/location/new", methods={"GET"}, name="location_new")
     */
    public function new(int $idUniverse)
    {
        $universe = $this->getDoctrine()
            ->getRepository(Universe::class)
            ->find($idUniverse);

        if (is_null($universe)) {
            throw $this->createNotFoundException();
        }

        $location = new Location();

        $form = $this->createForm(CreateLocationFormType::class, $location, [
            'universe_id' => $universe->getId(),
            'action' => $this->generateUrl('location_create', ['idUniverse' => $idUniverse])
        ]);

        return $this->render('location/new.html.twig', [
            'newLocationForm' => $form->createView(),
            'universe' => $universe,
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/universe/{idUniverse}/location/create", methods={"POST"}, name="location_create")
     */
    public function create(Request $request, FileUploaderService $fileUploader, int $idUniverse)
    {
        $universe = $this->getDoctrine()
            ->getRepository(Universe::class)
            ->find($idUniverse);

        if (is_null($universe)) {
            throw $this->createNotFoundException();
        }

        $location = new Location();

        $form = $this->createForm(CreateLocationFormType::class, $location, [
            'universe_id' => $universe->getId(),
            'action' => $this->generateUrl('location_create', ['idUniverse' => $idUniverse])
        ]);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $location->getimageURL();
            $filename = $fileUploader->upload($file);

            $location = $form->getData();
        
            // Insert the new story in the database 
            $location->setName(trim($location->getName()));
            $location->setDescription(trim($location->getDescription()));
            $location->setUniverse($universe);
            $location->setImageURL($filename);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($location);
            $entityManager->flush();

            return $this->redirectToRoute('location', [
                'idUniverse' => $location->getUniverse()->getId()
            ]);
        }

        return $this->render('location/new.html.twig', [
            'newLocationForm' => $form->createView(),
            'universe' => $universe,
            'user' => $this->getUser()
        ]);
    }
}
