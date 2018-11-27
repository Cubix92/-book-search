<?php

namespace Application\Repository;

use Application\Model\Book;
use Application\Service\Statistic\StatisticParameters;
use Doctrine\ORM\EntityRepository;

class BookRepository extends EntityRepository
{
    public function searchForStatistics(StatisticParameters $statisticParameters): array
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('b,r')
            ->from(Book::class, 'b')
            ->join('b.reviews', 'r');

        $expressionBuilder = $this->getEntityManager()->getExpressionBuilder();
        $expression = $expressionBuilder->andX();

        if (isset($statisticParameters['name'])) {
            $expression->add($expressionBuilder->like('b.name', ':name'));
            $queryBuilder->setParameter(':name', $statisticParameters['name'] );
        }

        if (isset($statisticParameters['maxAge'])) {
            $expression->add($expressionBuilder->lt('r.age', ':maxAge'));
            $queryBuilder->setParameter(':maxAge', $statisticParameters['maxAge'] );
        }

        if (isset($statisticParameters['minAge'])) {
            $expression->add($expressionBuilder->gt('r.age', ':minAge'));
            $queryBuilder->setParameter(':minAge', $statisticParameters['minAge'] );
        }

        $queryBuilder->where($expression);

        return $queryBuilder->getQuery()->getResult();
    }
}
