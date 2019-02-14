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
use Symfony\Component\HttpFoundation\Response;
use App\Form\CreateStoryFormType;

class StoryController extends AbstractController
{

    /**
     * @Route("/universe/{idUniverse<\d+>}/story/{idStory<\d+>}", name="story_show")
     * 
     * Show a story identified by its id
     * 
     * @param int $idUniverse Id of the story's universe
     * @param int $idStory Id of the chapter
     */
    public function show(int $idUniverse, int $idStory) : Response
    {
        // Get the story from the database
        $story = $this->getDoctrine()
            ->getRepository(Story::class)
            ->findOneByUniverseAndStoryId($idUniverse, $idStory);

            
        // If story is null then it doesn't exist
        if (is_null($story)) {
            throw $this->createNotFoundException('Not Found');
        }

        // Check if story is visible by the current user
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
     * @Route("/universe/{idUniverse<\d+>}/story/new", methods={"GET","POST"}, name="story_new")
     * 
     * POST : Insert the new story in the database
     * GET : Show a form to create a new story
     * 
     * @param int $idUniverse Id of the new story's universe
     * @param Request $request Request object to collect and use POST data
     */
    public function createStory(
        int $idUniverse,
        Request $request
    ) : Response {

        // Get the universe from the database
        $universe = $this->getDoctrine()
            ->getRepository(Universe::class)
            ->find($idUniverse);

        // If universe is null then it doesn't exist
        if (is_null($universe)) {
            throw $this->createNotFoundException('Not Found');
        }

        // Check if the user is a member of this universe
        if (is_null($this->getUser()) || !$universe->isMember($this->getUser())) {
            return $this->createAccessDeniedException('Unable to create a story in this universe');
        }

        $story = new Story();

        // Build the form
        $form = $this->createForm(CreateStoryFormType::class, $story);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $story = $form->getData();

            // Insert the new story in the database 

            $entityManager = $this->getDoctrine()->getManager();

            $story->setName(trim($story->getName()));
            $story->setDescription(trim($story->getDescription()));
            $story->setAuthor($this->getUser());
            $story->setUniverse($universe);
            $story->setCreationDate(new \DateTime('now', new \DateTimeZone('UTC')));
            $story->setStatus($this->getDoctrine() // story is by default on status INSCRIPTION
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
     * @Route("/universe/{idUniverse}/story/get/{order}/{afterDate?}", name="story_get")
     * 
     * Returns a json formated string that contains all stories 
     * from a universe after a given date and with a specific order
     * 
     * @param int $idUniverse Id of the story's universe
     * @param string $order The type of order. It can be :
     *      - "update" : sort by last update 
     *      - "create" : sort by creation date 
     *      - "top" : sort by activity (number of message in this story)
     * @param \DateTime $after (optional) Start date limit (inclusive)
     */
    public function getStories(
        int $idUniverse,
        string $order,
        ? \DateTime $afterDate
    ) : JsonResponse {

        // Get stories from the database
        $stories = $this->getDoctrine()
            ->getRepository(Story::class)
            ->findAfterWithOrder($idUniverse, $order, $afterDate);

        return new JsonResponse(
            $stories->map(function (Story $story) {
                return $story->toJson();
            })->toArray()
        );
    }
}
