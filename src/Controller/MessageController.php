<?php

namespace App\Controller;

use App\Entity\Chapter;
use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/universe/{idUniverse<\d+>}/story/{idStory<\d+>}/chapter/{idChapter<\d+>}/message/get/{beforeDate}/{afterDate?}", name="message_get")
     *
     * Returns a json formated string that contains all messages
     * from a chapter after a given date and before a given date
     *
     * @param int       $idUniverse Id of the chapter's universe
     * @param int       $idStory    Id of the chapter's story
     * @param int       $idChapter  Id of the chapter for the message
     * @param \DateTime $beforeDate inclusive end date
     * @param \DateTime $afterDate  inclusive start date, if omitted get all date
     *                              from chapter's creation date
     */
    public function getMessages(
        int $idUniverse,
        int $idStory,
        int $idChapter,
        \DateTime $beforeDate,
        ?\DateTime $afterDate
    ): JsonResponse {

        // Get messages from the database
        $messages = $this->getDoctrine()
            ->getRepository(Message::class)
            ->findAfterAndBeforeDate(
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
     * @Route("/universe/{idUniverse<\d+>}/story/{idStory<\d+>}/chapter/{idChapter<\d+>}/message/post", name="message_post", methods={"POST"})
     *
     * Insert a new message in the database
     *
     * @param int     $idUniverse Id of the chapter's universe
     * @param int     $idStory    Id of the chapter's story
     * @param int     $idChapter  Id of the chapter for the message
     * @param Request $request    Request object to collect and use POST data
     */
    public function create(
        int $idUniverse,
        int $idStory,
        int $idChapter,
        Request $request
    ): JsonResponse {

        // Get the chapter
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

        // If the user is not a player or the GM from this story then
        // he can't post a new message
        if (is_null($this->getUser())) {
            return $this->createAccessDeniedException('Unable to write a message in this story');
        }

        $persona = $chapter->getStory()->getPersonaByUser($this->getUser());

        if (is_null($persona) && !$chapter->getStory()->isAuthor($this->getUser())) {
            return $this->createAccessDeniedException('Unable to write a message in this story');
        }

        // Get post data
        $post_data = json_decode($request->getContent(), true);

        // Check if message field is not empty
        if (!array_key_exists('message', $post_data) || strcmp(trim($post_data['message']), '') === 0) {
            throw new BadRequestHttpException('Bad Request');
        }

        $contents = trim($post_data['message']);

        // Insert the new message in the database

        $entityManager = $this->getDoctrine()->getManager();

        $message = new Message();
        $message->setChapter($chapter);
        $message->setContents($contents);
        $message->setCreationDate(new \DateTime('now', new \DateTimeZone('UTC')));
        $message->setSender($this->getUser());

        $entityManager->persist($message);
        $entityManager->flush();

        return new JsonResponse();
    }
}
