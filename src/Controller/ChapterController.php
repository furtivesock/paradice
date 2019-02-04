<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Chapter;

class ChapterController extends AbstractController
{
    /**
     * @Route("universe/{idUniverse}/story/{idStory}/chapter/{idChapter}", name="chapter_show")
     */
    public function show(int $idUniverse, int $idStory, int $idChapter)
    {
        $chapter = $this->getDoctrine()
            ->getRepository(Chapter::class)
            ->findOneByUniverseAndStoryAndChapterId(
                $idUniverse, $idStory, $idChapter
            );

        return $this->render('chapter/show.html.twig', [
            'chapter' => $chapter,
            'user' => $this->getUser()
        ]);
    }
}
