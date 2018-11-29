<?php

namespace Application\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="reviews")
 */
class Review
{
    const SEX_MALE = 'm';
    const SEX_FEMALE = 'f';

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Book", inversedBy="reviews")
     */
    protected $book;

    /**
     * @ORM\Column(name="age", type="integer")
     */
    protected $age;

    /**
     * @ORM\Column(name="sex", type="string", columnDefinition="ENUM('m', 'f')")
     */
    protected $sex;

    public function getId(): int
    {
        return $this->id;
    }

    public function getBook(): Book
    {
        return $this->book;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getSex(): string
    {
        return $this->sex;
    }
}