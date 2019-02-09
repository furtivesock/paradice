<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Entity\Chapter;

class MessageController extends AbstractController
{
    /**
     * @Route("/universe/{idUniverse}/story/{idStory}/chapter/{idChapter}/message/get/{beforeDate}/{afterDate?}", name="message_get")
     */
    public function getMessages(
        int $idUniverse,
        int $idStory,
        int $idChapter,
        \DateTime $beforeDate,
        ? \DateTime $afterDate
    ) {
        $messages = $this->getDoctrine()
            ->getRepository(Message::class)
            ->findByUniverseStoryChapterIdAfterAndBeforeDate(
                $idUniverse,
                $idStory,
                $idChapter,
                $beforeDate,
                $afterDate
            );

        return new JsonResponse(
            $messages->map(function (Message $message) {
                return $message->toJson();
            })->toArray()
        );
    }

    /**
     * @Route("/universe/{idUniverse}/story/{idStory}/chapter/{idChapter}/message/post", name="message_post", methods={"POST"})
     */
    public function postMessages(
        int $idUniverse,
        int $idStory,
        int $idChapter,
        Request $request
    ) {
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

        $persona = $chapter->getStory()->getPersonaByUser($this->getUser());

        if (is_null($persona)) {
            return $this->createAccessDeniedException('Unable to write a message in this story');
        }

        $json = json_decode($request->getContent(), true);


        if (!array_key_exists('message', $json) || trim($json['message']) === '') {
            throw new BadRequestHttpException('Bad Request');
        }

        $contents = trim($json['message']);

        $entityManager = $this->getDoctrine()->getManager();

        $message = new Message();
        $message->setChapter($chapter);
        $message->setContents($contents);
        $message->setCreationDate(new \DateTime('now', new \DateTimeZone('UTC')));
        $message->setSender($persona);

        $entityManager->persist($message);
        $entityManager->flush();

        return new JsonResponse('success');
    }
}
