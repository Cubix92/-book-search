<?php

namespace Application\Service\Statistic;

use Application\Model\Book;

final class StatisticViewModel
{
    /** @var string $name */
    private $name;

    /** @var int $compatibility */
    private $compatibility;

    /** @var \DateTime $bookDate */
    private $bookDate;

    /** @var float $femaleAVG */
    private $femaleAVG;

    /** @var float $maleAVG */
    private $maleAVG;

    public function __construct(Book $book, int $compatibility, float $femaleAVG, float $maleAVG)
    {
        $this->name = $book->getName();
        $this->compatibility = $compatibility;
        $this->bookDate = $book->getBookDate()->format('Y-m-d');
        $this->femaleAVG = $femaleAVG;
        $this->maleAVG = $maleAVG;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCompatibility(): int
    {
        return $this->compatibility;
    }

    public function getBookDate(): string
    {
        return $this->bookDate;
    }

    public function getFemaleAVG(): float
    {
        return $this->femaleAVG;
    }

    public function getMaleAVG(): float
    {
        return $this->maleAVG;
    }
}