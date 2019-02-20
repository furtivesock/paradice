<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Status;
use Symfony\Component\HttpFoundation\JsonResponse;

class StatusController extends AbstractController
{
    /**
     * @Route("/status/get", name="status_get")
     */
    public function getAll() : JsonResponse
    {
        $status = $this->getDoctrine()
            ->getRepository(Status::class)
            ->findAll();

        return new JsonResponse(
            array_map(function(Status $s) {
                return $s->toJson();
            }, $status)
        );
    }
}
