<?php

namespace App\Controller;

use App\Entity\OnlineUser;
use App\Form\RegistrationFormType;
use App\Security\LoginAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Service\FileUploaderService;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * 
     * Register a new user 
     * 
     * @param Request $request Request object to collect and use POST data
     * @param UserPasswordEncoderInterface $passwordEncoder Interface to get the encoding algorithm
     * @param GuardAuthenticatorHandler $guardHandler Interface to check authentication
     * @param LoginAuthenticator $authenticator Interface to get the login authenticator
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler $guardHandler,
        LoginAuthenticator $authenticator,
        FileUploaderService $fileUploader
    ) : Response {
        
        $user = new OnlineUser();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $filename = $fileUploader->upload($user->getAvatarURL());

            // Encode the plain password (see config/packages/security.yaml 
            // for the encoding algorithm)
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setUsername($form->get('username')->getData());
            $user->setEmail($form->get('email')->getData());
            $user->setCreationDate(new \DateTime());
            $user->setAvatarURL($filename);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();


            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
