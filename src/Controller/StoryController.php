<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Story;

class StoryController extends AbstractController
{
    /**
     * @Route("universe/{idUniverse}/story/get/{order}/{afterDate?}", name="story_get")
     */
    public function getStories(int $idUniverse, string $order, ?\DateTime $afterDate)
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
