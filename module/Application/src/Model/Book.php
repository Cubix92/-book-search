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

    public function getCompatibility(string $keywords): int
    {
        $percentage = 0;
        similar_text(strtolower($this->name), $keywords, $percentage);

        return $percentage;
    }

    public function getBookDate(): \DateTime
    {
        return $this->bookDate;
    }

    public function getAverageAgeFor(string $sex): float
    {
        $avgAge = [];
        $average = 0;

        /** @var Review $review */
        foreach ($this->getReviews() as $review) {
            if ($review->getSex() == $sex) {
                $avgAge[] = $review->getAge();
            }
        }

        if (count($avgAge)) {
            $average = array_sum($avgAge)/count($avgAge);
        }

        return $average;
    }
}