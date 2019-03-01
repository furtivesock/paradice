<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Persona;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PersonaController extends AbstractController
{
    /**
     * @Route("/persona", name="persona")
     */
    public function index()
    {
        return $this->render('persona/index.html.twig', [
            'controller_name' => 'PersonaController',
        ]);
    }

    /**
     * @Route("/persona/create/{idUser}", name="persona_create", methods={"POST"})
     * 
     * POST : Insert the new unviverse in the database
     * 
     * @param Request $request Request object to collect and use POST data
     */
    public function create(Request $request, int $idUser): Response
    {    
        $user = $this->getDoctrine()
            ->getRepository(OnlineUser::class)
            ->find($idUser);
        
        if (is_null($user)) {
            throw $this->createNotFoundException();
        }

        if (!is_null($this->getUser()) && $this->getUser()->getId() !== $user->getId()) {
            throw $this->createAccessDeniedException();
        }
        // Check if the user is a member of this universe
        if (is_null($this->getUser())) {
            throw $this->createAccessDeniedException('You lust bo logged in to create persona.');
        }

        $persona = new Persona();

        // Build the form
        $form = $this->createForm(CreateUniverseFormType::class, $persona, array(
            'action' => $this->generateUrl('persona_create')
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $persona = $form->getData();

            // Insert the new story in the database 

            $entityManager = $this->getDoctrine()->getManager();

            $persona->setFirstname(trim($persona->getFirstname()));
            $persona->setPhysicalDescription(trim($persona->getPhysicalDescription()));
            $persona->setPersonality($this->getPersonality());
            $persona->setBackground($this->getBackground());
            $persona->setAvatarURL($this->getAvatarURL());
            $persona->setLastName($this->getLastName());
            $persona->setAge($this->getAge());
            $persona->setUniverse($this->getUniverse());
            $persona->setUser($user);

            $entityManager->persist($persona);
            $entityManager->flush();

            return $this->redirectToRoute('persona_show', [
                'idPersona' => $persona->getId(),
                'user' => $this->getUser()
            ]);
        }

        return $this->render('persona/new.html.twig', [
            'newPersonaForm' => $form->createView(),
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/persona/new/{idUser}", name="persona_new", methods={"GET"})
     * 
     * GET : Show a form to create a new persona
     */
    public function new()
    {
        // Check if the user is a member of this universe
        if (is_null($this->getUser())) {
            throw $this->createAccessDeniedException('You lust bo logged in to create persona.');
        }

        $persona = new Persona();

        // Build the form
        $form = $this->createForm(CreateUniverseFormType::class, $persona, array(
            'action' => $this->generateUrl('persona_create, idUser')
        ));


        return $this->render('persona/new.html.twig', [
            'newPersonaForm' => $form->createView(),
            'user' => $this->getUser()
        ]);
    }
}
