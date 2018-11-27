<?php

namespace Application\Service;

use Application\Model\Review;
use Doctrine\Common\Collections\Collection;

class AgesService
{
    public function getAverageAgeForReviews(Collection $reviews, string $sex): float
    {
        $avgAge = [];
        $average = 0;

        /** @var Review $review */
        foreach ($reviews as $review) {
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