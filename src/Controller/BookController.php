<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;

class BookController extends AbstractController
{
    #[Route('api/books', name: 'api_book_index', methods: ['GET'])]
    public function index(BookRepository $bookRepository)
    {
        return $this->json($bookRepository->findAll(), 200, [], ['groups' => 'post:read']);
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

   /* #[Route('api/books', name: 'app_book')]
    public function getBookList(BookRepository $bookRepository, SerializerInterface $serializer): JsonResponse
    {
        $bookList = $bookRepository->findAll();
        $jsonBookList = $serializer->serialize($bookList, 'json');
        return new JsonResponse($jsonBookList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/books/{id}', name: 'detailBook', methods: ['POST'])]
    public function getDetailBook(Book $book, SerializerInterface $serializer): JsonResponse 
    {
        $jsonBook = $serializer->serialize($book, 'json');
        return new JsonResponse($jsonBook, Response::HTTP_OK, ['accept' => 'json'], true);
    }*/
} 