<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Chapter;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Location;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Story;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use App\Form\CreateChapterFormType;

class ChapterController extends AbstractController
{
    /**
     * @Route("/universe/{idUniverse<\d+>}/story/{idStory<\d+>}/chapter/{idChapter<\d+>}", name="chapter_show")
     * 
     * Show a chapter identified by its id
     * 
     * @param int $idUniverse Id of the chapter's universe
     * @param int $idStory Id of the chapter's story
     * @param int $idChapter Id of the chapter
     */
    public function show(
        int $idUniverse,
        int $idStory,
        int $idChapter
    ) : Response {

        // Get the chapter from the database
        $chapter = $this->getDoctrine()
            ->getRepository(Chapter::class)
            ->findOneByIds(
                $idUniverse,
                $idStory,
                $idChapter
            );
        
        // If chapter is null then it doesn't exist
        if (is_null($chapter)) {
            throw $this->createNotFoundException('Not Found');
        }

        // If the current user doesn't have the permission to see 
        // this chapter, we don't show him
        if (!$chapter->getStory()->isVisibleByUser($this->getUser())) {
            return $this->render('story/private.html.twig', [
                'story' => $chapter->getStory()
            ]);
        }

        return $this->render('chapter/show.html.twig', [
            'chapter' => $chapter,
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/universe/{idUniverse<\d+>}/story/{idStory<\d+>}/chapter/new", methods={"GET","POST"}, name="chapter_new")
     * 
     * POST : Insert the new chapter in the database
     * GET : Show a form to create a new chapter
     * Show a chapter identified by its id
     * 
     * @param int $idUniverse Id of the chapter's universe
     * @param int $idStory Id of the chapter's story
     * @param Request $request Request object to collect and use POST data
     */
    public function create(
        int $idUniverse,
        int $idStory,
        Request $request
    ) : Response {

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

        // If the user is not the story's author then he can't create
        // a new chapter
        if (is_null($this->getUser()) || !$story->isAuthor($this->getUser())) {
            return $this->createAccessDeniedException('Unable to create a chapter in this story');
        }

        // Get the last chapter in order to get the numero for the new one
        $lastChapter = $this->getDoctrine()
            ->getRepository(Chapter::class)
            ->findLastChapterOfStory($story->getUniverse()->getId(), $story->getId());

        $chapter = new Chapter();

        // Build the form 
        $form = $this->createForm(
            CreateChapterFormType::class, 
            $chapter, 
            array('id' => $story->getUniverse()->getId())
        );

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $chapter = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();

            $chapter->setName(trim($chapter->getName()));
            $chapter->setEnd(false); // A new chapter is by default not finished
            $chapter->setStory($story);
            $chapter->setNumero(is_null($lastChapter) ? 1 : $lastChapter->getNumero() + 1);

            // Insert the new chapter in the database
            $entityManager->persist($chapter);
            $entityManager->flush();

            return $this->redirectToRoute('story_show', [
                'idUniverse' => $story->getUniverse()->getId(),
                'idStory' => $story->getId(),
                'user' => $this->getUser(),
            ]);
        }

        return $this->render('chapter/new.html.twig', [
            'newChapterForm' => $form->createView(),
            'numero' => is_null($lastChapter) ? 1 : $lastChapter->getNumero() + 1,
            'user' => $this->getUser(),
            'story' => $story
        ]);


    }

}
