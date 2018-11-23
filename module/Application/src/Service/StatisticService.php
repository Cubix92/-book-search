<?php

namespace Application\Service;

use Application\Model\Book;
use Application\Model\Review;
use Application\Repository\BookRepository;
use Application\Service\Book\BookDTO;

class StatisticService
{
    protected $bookRepository;

    protected $statisticParser;

    public function __construct(BookRepository $bookRepository, StatisticParser $statisticParser)
    {
        $this->bookRepository = $bookRepository;
        $this->statisticParser = $statisticParser;
    }

    public function showStatistics(string $parameter): array
    {
        $statisticParameters = $this->statisticParser->parse($parameter);
        $books = $this->bookRepository->searchForStatistics($statisticParameters);

        if (!$books) {
            $books = $this->bookRepository->searchForStatistics($statisticParameters->filter(function($key, $value) {
                return $key == 'name' ? null : $value;
            }));
        }

        return $this->prepareStatistics($books, $statisticParameters['name']);
    }

    protected function prepareStatistics(array $books, string $nameOfBook): array
    {
        $booksResults = [];

        /** @var Book $book */
        foreach ($books as $book) {
            $booksResults[] = new BookDTO(
                $book->getName(),
                $book->getCompatibility($nameOfBook),
                $book->getBookDate()->format('Y-m-d'),
                $book->getAverageAgeFor(Review::SEX_FEMALE),
                $book->getAverageAgeFor(Review::SEX_MALE)
            );
        }

        usort($booksResults, function($a, $b) {
            return $a->compatibility < $b->compatibility;
        });

        return $booksResults;
    }
}