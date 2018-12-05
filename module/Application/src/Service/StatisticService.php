<?php

namespace Application\Service;

use Application\Model\Book;
use Application\Model\Review;
use Application\Repository\BookRepository;
use Application\Service\Statistic\StatisticParser;
use Application\Service\Statistic\StatisticViewModel;

class StatisticService
{
    protected $bookRepository;

    protected $statisticParser;

    protected $compatbilityService;

    protected $agesService;

    public function __construct(
        BookRepository $bookRepository,
        StatisticParser $statisticParser,
        CompatibilityService $compatbilityService,
        AgesService $agesService
    ) {
        $this->bookRepository = $bookRepository;
        $this->statisticParser = $statisticParser;
        $this->compatbilityService = $compatbilityService;
        $this->agesService = $agesService;
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

    public function prepareStatistics(array $books, string $nameOfBook): array
    {
        $booksResults = [];

        /** @var Book $book */
        foreach ($books as $book) {
            $booksResults[] = new StatisticViewModel(
                $book,
                $this->compatbilityService->getCompatibilityOf($book->getName(), $nameOfBook),
                $this->agesService->getAverageAgeForReviews($book->getReviews(), Review::SEX_FEMALE),
                $this->agesService->getAverageAgeForReviews($book->getReviews(), Review::SEX_MALE)
            );
        }

        usort($booksResults, function($a, $b) {
            /**
             * @var StatisticViewModel $a
             * @var StatisticViewModel $b
             */
            return $a->getCompatibility() < $b->getCompatibility();
        });

        return $booksResults;
    }
}