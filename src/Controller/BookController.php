<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Borrow;
use App\Repository\BookRepository;
use App\Repository\BorrowRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;

class BookController extends AbstractController
{
    #[Route('/api/search/book/get', name: 'api_book_get', methods: ["GET"])]
    public function GetBook (BookRepository $bookRepository)
    {
      return $this->json($bookRepository->findAll(),200,[],['groups' => 'post:read']);
    }
  
    #[Route('/api/book/post', name: 'api_book_post', methods: ["POST"])]
    public function store (Request $request, SerializerInterface $serializer, EntityManagerInterface $em){
      try {  
        $json = $request->getContent();

        $post = $serializer->deserialize($json, Book::class, 'json');

        //$post->setTitle(new \DateTime());

        $em->persist($post);
        $em->flush();

        return $this->json($post, 201, [], ['groups' => 'post:read']);
      } catch(NotEncodableValueException $e){
        return $this->json([
            'status' => 400,
            'message' => $e->getMessage()
        ], 400);
      }
    }

    
    #[Route('/api/v1/book/{id}/{id_book}/borrow', name: 'api_book_borrow', methods: ["POST"])]
    public function BorrowBook(EntityManagerInterface $entityManager, Request $request, BookRepository $bookRepository, UserRepository $userRepository) :Response
    {
  
      $userId = $request->get("id");
      $user = $userRepository->find($userId);
      $bookId = $request->get("id_book");
      $book = $bookRepository->find($bookId);
      $borrow = new Borrow;

      $borrow->setUser($user);
      $borrow->setBook($book);
      $borrow->setDateBorrow(new DateTime());
      $book->setIsAvailable(false);
     

      $entityManager->persist($borrow);
      $entityManager->flush();

      return $this->json(["Message" => "Book borrowed"]);
    }


    
    #[Route('/api/v1/book/{id}/{id_book}/return', name: 'api_book_return', methods: ["PATCH"])]
    public function ReturnBook(EntityManagerInterface $entityManager, Request $request, BookRepository $bookRepository, BorrowRepository $borrowRepository, UserRepository $userRepository) :Response
    {
      $userId = $request->get("id");
      $user = $userRepository->find($userId); 
      $bookId = $request->get("id_book");
      $book = $bookRepository->find($bookId);
      $borrowBook = $book->getBorrow()->first()->getId();
      $borrow = $borrowRepository->find($borrowBook);
      $borrow->setReturnDate(new DateTime());
      $book->setIsAvailable(true);
      
      $entityManager->persist($borrow);
      $entityManager->flush();

      return $this->json(["Message" => "Book return"]);
    }




} 