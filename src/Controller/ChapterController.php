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

class ChapterController extends AbstractController
{
    /**
     * @Route("universe/{idUniverse<\d+>}/story/{idStory<\d+>}/chapter/{idChapter<\d+>}", name="chapter_show")
     */
    public function show(int $idUniverse, int $idStory, int $idChapter)
    {
        $chapter = $this->getDoctrine()
            ->getRepository(Chapter::class)
            ->findOneByUniverseAndStoryAndChapterId(
                $idUniverse,
                $idStory,
                $idChapter
            );

        if (is_null($chapter)) {
            throw $this->createNotFoundException('Not Found');
        }

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
     * @Route("universe/{idUniverse<\d+>}/story/{idStory<\d+>}/chapter/new", methods={"GET","POST"}, name="chapter_new")
     */
    public function createChapter(
        int $idUniverse,
        int $idStory,
        Request $request
    ) {

        $story = $this->getDoctrine()
            ->getRepository(Story::class)
            ->findOneByUniverseAndStoryId(
                $idUniverse,
                $idStory
            );

        if (is_null($story)) {
            throw $this->createNotFoundException('Not Found');
        }

        if (is_null($this->getUser())) {
            return $this->createAccessDeniedException('Unable to create a chapter in this story');
        }

        if (!$story->isAuthor($this->getUser())) {
            return $this->createAccessDeniedException('Unable to create a chapter in this story');
        }

        $lastChapter = $this->getDoctrine()
            ->getRepository(Chapter::class)
            ->findLastChapterOfStory($story->getUniverse()->getId(), $story->getId());

        $chapter = new Chapter();

        $form = $this->createFormBuilder($chapter)
            ->add('name', TextType::class)
            ->add('location', ChoiceType::class, [
                'choices' => $this->getDoctrine()
                    ->getRepository(Location::class)
                    ->findLocationsByUniverseId($idUniverse),
                'choice_label' => function (Location $location, $key, $value) {
                    return $location->getName();
                },
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chapter = $form->getData();
            
            $entityManager = $this->getDoctrine()->getManager();

            $chapter->setName(trim($chapter->getName()));
            $chapter->setEnd(false);
            $chapter->setStory($story);
            $chapter->setNumero(is_null($lastChapter) ? 1 : $lastChapter->getNumero() + 1);

            $entityManager->persist($chapter);
            $entityManager->flush();

            return $this->redirectToRoute('story_show', [
                'idUniverse' => $story->getUniverse()->getId(),
                'idStory' => $story->getId(),
            ]);
        }

        return $this->render('chapter/new.html.twig', [
            'newChapterForm' => $form->createView(),
            'numero' => is_null($lastChapter) ? 1 : $lastChapter->getNumero() + 1
        ]);


    }

}
