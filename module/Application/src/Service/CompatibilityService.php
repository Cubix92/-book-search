<?php

namespace Application\Service;

use Application\Model\Book;
use Application\Model\Review;
use Application\Repository\BookRepository;
use Application\Service\Statistic\BookViewModel;

class CompatibilityService
{
    public function getCompatibilityOf(string $first, string $second): float
    {
        $percentage = 0;
        similar_text(strtolower($first), strtolower($second), $percentage);

        return $percentage;
    }
}