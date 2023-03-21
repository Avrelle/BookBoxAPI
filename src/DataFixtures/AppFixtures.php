<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création d'une vingtaine de livres ayant pour titre
        
            $book = new Book;
            $book->setTitle('Livre : ' . 'La ligne verte');
            $book->setAuthor('Author : ' . 'Stephen King');
            $book->setIsbn(97);
            $book->setIsAvailable('Available : ' . true);
            $book->setCover('Cover : ' . 'https://www.livredepoche.com/sites/default/files/images/livres/couv/9782253122920-001-T.jpeg');
            $book->setResume('Resume : ' . 'Paul Edgecombe, ancien gardien-chef d\'\un pénitencier dans les années 1930, entreprend d\'\écrire ses mémoires. Il revient sur l\'\affaire John Caffey – ce grand Noir au regard absent, condamné à mort pour le viol et le meurtre de deux fillettes – qui défraya la chronique en 1932.');
            

            $manager->persist($book);
        
      

        $manager->flush();
    }
}