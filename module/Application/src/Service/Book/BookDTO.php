<?php

namespace Application\Service\Book;

class BookDTO
{
    public $name;

    public $compatibility;

    public $bookDate;

    public $femaleAVG;

    public $maleAVG;

    public function __construct(string $name, int $compatibility, string $bookDate, float $femaleAVG, float $maleAVG)
    {
        $this->name = $name;
        $this->compatibility = $compatibility;
        $this->bookDate = $bookDate;
        $this->femaleAVG = $femaleAVG;
        $this->maleAVG = $maleAVG;
    }
}