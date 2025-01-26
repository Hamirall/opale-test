<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Recall;

final class RecallController extends AbstractController
{
    #[Route("/recall", name: "app_recall")]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $name = $request->query->get("name");

        $recalls = $entityManager
            ->getRepository(Recall::class)
            ->findAllOrByName($name);

        return $this->json($recalls, 200, [], ["groups" => "recall:read"]);
    }
}
