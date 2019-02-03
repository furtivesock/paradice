<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Story;

class StoryController extends AbstractController
{
    /**
     * @Route("universe/{idUniverse}/story/get/{order}", name="story_get")
     */
    public function getStories(int $idUniverse, string $order)
    {
        switch ($order) {
            case 'update':
                $stories = $this->getDoctrine()
                    ->getRepository(Story::class)
                    ->findStoriesOrderedByLastUpdate($idUniverse);
                break;
            case 'create':
                $stories = $this->getDoctrine()
                    ->getRepository(Story::class)
                    ->findStoriesOrderedByCreationDate($idUniverse);
                break;
            case 'top_day':
            case 'top_week':
            case 'top_month':
            case 'top_year':
            case 'top_all':
                $stories = $this->getDoctrine()
                    ->getRepository(Story::class)
                    ->findStoriesOrderedByActivity($idUniverse, $order);
                break;
            default:
                $stories = new ArrayCollection();
                break;
        }
        
        return new JsonResponse(
            $stories->map(function (Story $story) {
                return $story->toJson();
            })->toArray()
        );
    }
}
