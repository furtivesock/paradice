<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Story;

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
