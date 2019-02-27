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
    public function show(int $idUniverse, int $idStory): Response
    {
        // Get the story from the database
        $story = $this->getDoctrine()
            ->getRepository(Story::class)
            ->findOneBy(array(
                'id' => $idStory,
                'universe' => $idUniverse
            ));


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
     * @Route("/universe/{idUniverse<\d+>}/story/create", methods={"POST"}, name="story_create")
     * 
     * POST : Insert the new story in the database
     * 
     * @param int $idUniverse Id of the new story's universe
     * @param Request $request Request object to collect and use POST data
     */
    public function create(
        int $idUniverse,
        Request $request
    ): Response {

        // Get the universe from the database
        $universe = $this->getDoctrine()
            ->getRepository(Universe::class)
            ->find($idUniverse);

        // If universe is null then it doesn't exist
        if (is_null($universe)) {
            throw $this->createNotFoundException('Not Found');
        }

        // Check if the user is a member of this universe
        if (is_null($this->getUser()) || !$universe->canCreateStory($this->getUser())) {
            throw $this->createAccessDeniedException('Unable to create a story in this universe');
        }

        $story = new Story();

        // Build the form
        $form = $this->createForm(CreateStoryFormType::class, $story, array(
            'action' => $this->generateUrl('story_create', ['idUniverse' => $idUniverse])
        ));

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
            'newStoryForm' => $form->createView(),
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/universe/{idUniverse<\d+>}/story/new", name="story_new", methods={"GET"})
     * 
     * GET : Show a form to create a new universe
     */
    public function new(
        int $idUniverse
    ): Response {

        // Get the universe from the database
        $universe = $this->getDoctrine()
            ->getRepository(Universe::class)
            ->find($idUniverse);

        // If universe is null then it doesn't exist
        if (is_null($universe)) {
            throw $this->createNotFoundException('Not Found');
        }

        // Check if the user is a member of this universe
        if (is_null($this->getUser()) || !$universe->canCreateStory($this->getUser())) {
            throw $this->createAccessDeniedException('Unable to create a story in this universe');
        }

        $story = new Story();

        // Build the form
        $form = $this->createForm(CreateStoryFormType::class, $story, array(
            'action' => $this->generateUrl('story_create', ['idUniverse' => $idUniverse])
        ));

        return $this->render('story/new.html.twig', [
            'newStoryForm' => $form->createView(),
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/universe/{idUniverse<\d+>}/story/{idStory<\d+>}/status", methods={"POST"}, name="story_status")
     */
    public function changeStatus(
        int $idUniverse,
        int $idStory,
        Request $request
    ): JsonResponse {
        $story = $this->getDoctrine()
            ->getRepository(Story::class)
            ->findOneBy(array(
                'id' => $idStory,
                'universe' => $idUniverse
            ));

        // If story is null then it doesn't exist
        if (is_null($story)) {
            throw $this->createNotFoundException('Not Found');
        }

        // Check if the user is the story's author
        if (is_null($this->getUser()) || !$story->isAuthor($this->getUser())) {
            throw $this->createAccessDeniedException('Unable to change the status of this story.');
        }

        $post_data = json_decode($request->getContent(), true);

        // Check if message field is not empty
        if (!array_key_exists('status', $post_data)) {
            throw new BadRequestHttpException('Bad Request');
        }

        $status = $this->getDoctrine()
            ->getRepository(Status::class)
            ->findOneBy(array(
                'id' => $post_data['status']
            ));

        if (is_null($status)) {
            throw new BadRequestHttpException('Bad Request');
        }

        $entityManager = $this->getDoctrine()->getManager();

        $story->setStatus($status);

        $entityManager->persist($story);
        $entityManager->flush();

        return new JsonResponse();
    }

    /**
     * @Route("/universe/{idUniverse<\d+>}/story/get/{order}/{afterDate?}", name="story_get")
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
    public function getAll(
        int $idUniverse,
        string $order,
        ? \DateTime $afterDate
    ): JsonResponse {

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

    /**
     * @Route("/universe/{idUniverse<\d+>}/story/{idStory<\d+>}/get", name="story_get_one")
     */
    public function getOne(
        int $idUniverse,
        int $idStory
    ): JsonResponse {

        // Get stories from the database
        $story = $this->getDoctrine()
            ->getRepository(Story::class)
            ->findOneBy(array(
                'id' => $idStory,
                'universe' => $idUniverse
            ));

        // If story is null then it doesn't exist
        if (is_null($story)) {
            throw $this->createNotFoundException('Not Found');
        }

        return new JsonResponse(
            $story->toJson()
        );
    }
}
