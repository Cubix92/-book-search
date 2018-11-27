<?php

namespace Application\Service\Statistic;

use Application\Model\Book;

class StatisticViewModel
{
    public $name;

    public $compatibility;

    public $bookDate;

    public $femaleAVG;

    public $maleAVG;

    public function __construct(Book $book, int $compatibility, float $femaleAVG, float $maleAVG)
    {
        $this->name = $book->getName();
        $this->compatibility = $compatibility;
        $this->bookDate = $book->getBookDate()->format('Y-m-d');
        $this->femaleAVG = $femaleAVG;
        $this->maleAVG = $maleAVG;
    }
}