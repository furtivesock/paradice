<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UpdateUserFormType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\OnlineUser;
use App\Service\FileUploaderService;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{idUser}", methods={"GET"}, name="user_show")
     */
    public function show(int $idUser)
    {
        $user = $this->getDoctrine()
            ->getRepository(OnlineUser::class)
            ->find($idUser);
        
        if (is_null($user)) {
            throw $this->createNotFoundException();
        }

        $me = true;
        if (is_null($this->getUser()) || $this->getUser()->getId() !== $user->getId()) {
            $me = false;
        }

        return $this->render('user/show.html.twig', [
            'userProfile' => $user,
            'me' => $me
        ]);
    }

    /**
     * @Route("/user/{idUser}", methods={"GET"}, name="user_edit")
     */
    public function edit(int $idUser)
    {
        $user = $this->getDoctrine()
            ->getRepository(OnlineUser::class)
            ->find($idUser);
        
        if (is_null($user)) {
            throw $this->createNotFoundException();
        }

        if (is_null($this->getUser()) || $this->getUser()->getId() !== $user->getId()) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(UpdateUserFormType::class, $user, [
            'action' => $this->generateUrl('user_update', [
                'idUser' => $user->getId()
            ])
        ]);

        return $this->render('user/edit.html.twig', [
            'editUserForm' => $form->createView(),
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/user/{idUser}", methods={"POST"}, name="user_update")
     */
    public function update(Request $request, FileUploaderService $fileUploader, int $idUser)
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

        $form = $this->createForm(UpdateUserFormType::class, $user, [
            'action' => $this->generateUrl('user_update', [
                'idUser' => $user->getId(),
                'user' => $this->getUser()
            ])
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filename = $fileUploader->upload($user->getAvatarURL());

            // Update the user in the database 
            $entityManager = $this->getDoctrine()->getManager();

            $user->setAvatarURL($filename);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_show', [
                'idUser' => $user->getId(),
            ]);
        }

        return $this->render('user/edit.html.twig', [
            'editUserForm' => $form->createView(),
            'user' => $this->getUser()
        ]);
    }
}
