<?php

// src/Entity/Book.php
namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Title is required.")]
    private ?string $title = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Author is required.")]
    private ?string $author = null;

    #[ORM\Column(type: 'string', length: 13)]
    #[Assert\NotBlank(message: "ISBN is required.")]
    #[Assert\Length(
        min: 10,
        max: 13,
        minMessage: "ISBN must be at least {{ limit }} characters long",
        maxMessage: "ISBN cannot be longer than {{ limit }} characters"
    )]
    private ?string $isbn = null;

    #[ORM\Column(type: 'date')]
    #[Assert\NotBlank(message: "Publication date is required.")]
    private ?\DateTimeInterface $publicationDate = null;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\NotBlank(message: "Genre is required.")]
    private ?string $genre = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message: "Number of copies is required.")]
    #[Assert\Positive(message: "Number of copies must be a positive number.")]
    private ?int $numberOfCopies = null;

    // Getters and Setters...

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

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(\DateTimeInterface $publicationDate): self
    {
        $this->publicationDate = $publicationDate;
        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;
        return $this;
    }

    public function getNumberOfCopies(): ?int
    {
        return $this->numberOfCopies;
    }

    public function setNumberOfCopies(int $numberOfCopies): self
    {
        $this->numberOfCopies = $numberOfCopies;
        return $this;
    }
}
