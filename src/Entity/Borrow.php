<?php

namespace App\Entity;

use App\Repository\BorrowRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BorrowRepository::class)]
class Borrow
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("borrow:read")]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE,nullable:true)]
    #[Groups("borrow:read")]
    private ?\DateTimeInterface $dateBorrow = null;

    #[ORM\Column(type: Types::DATE_MUTABLE,nullable:true)]
    #[Groups("borrow:read")]
    private ?\DateTimeInterface $returnDate = null;

    #[ORM\ManyToOne(inversedBy: 'borrow')]
    #[Groups("borrow:read")]
    private ?Book $book = null;

    #[ORM\ManyToOne(inversedBy: 'borrow')]
    #[Groups("borrow:read")]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateBorrow(): ?\DateTimeInterface
    {
        return $this->dateBorrow;
    }

    public function setDateBorrow(\DateTimeInterface $dateBorrow): self
    {
        $this->dateBorrow = $dateBorrow;

        return $this;
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->returnDate;
    }

    public function setReturnDate(\DateTimeInterface $returnDate): self
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
    public function __toString(){
        
       
        return (string) $this->id;
    }
}