<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Story;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Visibility;
use App\Entity\Status;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Universe;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class StoryController extends AbstractController
{

    /**
     * @Route("universe/{idUniverse<\d+>}/story/{idStory<\d+>}", name="story_show")
     */
    public function show(int $idUniverse, int $idStory)
    {
        $story = $this->getDoctrine()
            ->getRepository(Story::class)
            ->findOneByUniverseAndStoryId($idUniverse, $idStory);

        if (is_null($story)) {
            throw $this->createNotFoundException('Not Found');
        }

        if (!$story->isVisibleByUser($this->getUser())) {
            return $this->render('story/private.html.twig', [
                'story' => $story
            ]);
        }

        return $this->render('story/show.html.twig', [
            'story' => $story,
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("universe/{idUniverse<\d+>}/story/new", methods={"GET","POST"}, name="story_new")
     */
    public function createStory(
        int $idUniverse,
        Request $request
    ) {

        $universe = $this->getDoctrine()
            ->getRepository(Universe::class)
            ->find($idUniverse);

        if (is_null($universe)) {
            throw $this->createNotFoundException('Not Found');
        }

        if (is_null($this->getUser())) {
            return $this->createAccessDeniedException('Unable to create a story in this universe');
        }

        if (!$universe->isMember($this->getUser())) {
            return $this->createAccessDeniedException('Unable to create a story in this universe');
        }

        $story = new Story();

        $form = $this->createFormBuilder($story)
            ->add('name', TextType::class, ['label' => 'Nom de l\'histoire'])
            ->add('description', TextareaType::class, ['label' => 'Description'])
            ->add('startDate', DateTimeType::class, ['label' => 'Date de lancement'])
            ->add('endRegistrationDate', DateTimeType::class, ['label' => 'Date de fin des inscriptions'])
            ->add('visibility', ChoiceType::class, [
                'choices' => $this->getDoctrine()
                    ->getRepository(Visibility::class)
                    ->findAll(),
                'choice_label' => function (Visibility $visibility, $key, $value) {
                    switch ($visibility->getName()) {
                        case 'ALL':
                            return 'Par tout le monde';
                        case 'UNIVERSE':
                            return 'Par les membres de cet universe';
                        case 'STORY':
                            return 'Par les joueurs de cette histoire';
                    }
                },
                'label' => 'Visibilité'
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $story = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();

            $story->setName(trim($story->getName()));
            $story->setDescription(trim($story->getDescription()));
            $story->setAuthor($this->getUser());
            $story->setUniverse($universe);
            $story->setCreationDate(new \DateTime('now', new \DateTimeZone('UTC')));
            $story->setStatus($this->getDoctrine()
                ->getRepository(Status::class)
                ->findOneBy(['name' => 'INSCRIPTION']));

            $entityManager->persist($story);
            $entityManager->flush();

            return $this->redirectToRoute('universe_show', [
                'idUniverse' => $story->getUniverse()->getId()
            ]);
        }

        return $this->render('story/new.html.twig', [
            'newStoryForm' => $form->createView()
        ]);

    }

    /**
     * @Route("universe/{idUniverse}/story/get/{order}/{afterDate?}", name="story_get")
     */
    public function getStories(int $idUniverse, string $order, ? \DateTime $afterDate)
    {
        $stories = $this->getDoctrine()
            ->getRepository(Story::class)
            ->findStoriesAfterDateAndOrdered($idUniverse, $order, $afterDate);

        return new JsonResponse(
            $stories->map(function (Story $story) {
                return $story->toJson();
            })->toArray()
        );
    }
}
