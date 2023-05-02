<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("post:read")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups("post:read")]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups("post:read")]
    private ?string $author = null;

    #[ORM\Column(type:Types::BIGINT)]
    #[Groups("post:read")]
    private ?string $isbn = null;

    #[ORM\Column]
    #[Groups("post:read")]
    private ?bool $isAvailable = null;

    #[ORM\Column(length: 255)]
    #[Groups("post:read")]
    private ?string $cover = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups("post:read")]
    private ?string $resume = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'books')]
    #[Groups("post:read")]
    private Collection $category;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[Groups("post:read")]
    private ?Box $box = null;

    #[ORM\OneToMany(mappedBy: 'book', targetEntity: Borrow::class)]
    #[Groups("post:read")]
    private Collection $borrow;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->borrow = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function isIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * @return Collection<int, category>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
        }

        return $this;
    }

    public function removeCategory(category $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }

    public function getBox(): ?Box
    {
        return $this->box;
    }

    public function setBox(?Box $box): self
    {
        $this->box = $box;

        return $this;
    }

    /**
     * @return Collection<int, borrow>
     */
    public function getBorrow(): Collection
    {
        return $this->borrow;
    }

    public function addBorrow(borrow $borrow): self
    {
        if (!$this->borrow->contains($borrow)) {
            $this->borrow->add($borrow);
            $borrow->setBook($this);
        }

        return $this;
    }

    public function removeBorrow(borrow $borrow): self
    {
        if ($this->borrow->removeElement($borrow)) {
            // set the owning side to null (unless already changed)
            if ($borrow->getBook() === $this) {
                $borrow->setBook(null);
            }
        }

        return $this;
    }
    public function __toString(){
        
       
        return (string) $this->id;
    }
   
}