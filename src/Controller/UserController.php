<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    #[Route('/api/users', name: 'api_all_user_get', methods: ["GET"])]
    public function GetBook (UserRepository $userRepository)
    {
      return $this->json($userRepository->findAll(),200,[],['groups' => 'user:read']);
    }
//User scan card
    #[Route('/api/v1/users/login', name: 'UserUuid', methods:["POST"])]
    public function getUsersByUuid(SerializerInterface $serializer, Request $request) : Response
    {
        $userUuid = json_decode($request->getContent(), true);
        $uuid = $userUuid['uuid'];
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(["uuid" => $uuid]);

        if(!$users){
            return $this->json(["error" => "Utilisateur inexistant"]);
        }    
        
        $json = $serializer -> serialize($users, 'json',['groups' => 'user:read']);
        $response = new Response($json, 200, ["Content-Type" => "application/json"]);
        return $response;

    }


}