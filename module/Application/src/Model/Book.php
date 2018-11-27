<?php

namespace Application\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Application\Repository\BookRepository")
 * @ORM\Table(name="books")
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Review", mappedBy="book")
     */
    protected $reviews;

    /**
     * @ORM\Column(name="name", type="string", length=56)
     */
    protected $name;

    /**
     * @ORM\Column(name="book_date", type="date")
     */
    protected $bookDate;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBookDate(): \DateTime
    {
        return $this->bookDate;
    }
}