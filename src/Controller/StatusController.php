<?php

namespace App\Controller;

use App\Entity\Status;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class StatusController extends AbstractController
{
    /**
     * @Route("/status/get", name="status_get")
     */
    public function getAll(): JsonResponse
    {
        $status = $this->getDoctrine()
            ->getRepository(Status::class)
            ->findAll();

        return new JsonResponse(
            array_map(function (Status $s) {
                return $s->toJson();
            }, $status)
        );
    }
}
