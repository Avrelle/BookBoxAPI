<?php

namespace App\Controller;

use App\Repository\BoxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoxController extends AbstractController
{
    #[Route('/api/v1/box',name: 'api_box_get', methods: ["GET"])]
    public function GetBox(BoxRepository $boxRepository): Response
    {
        return $this->json($boxRepository->findAll(),200,[],['groups' => 'get:box']);
    }
}