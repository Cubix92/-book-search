<?php

namespace ApplicationTest\Model;

use Application\Model\Review;
use Application\Service\AgesService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;
use Zend\Hydrator\Reflection;

class AgesServiceTest extends TestCase
{
    public function createReviews(): Collection
    {
        $reflectionHydrator = new Reflection;

        $data = [
            [
                'id' => 1,
                'age' => 20,
                'sex' => Review::SEX_FEMALE
            ],
            [
                'id' => 2,
                'age' => 30,
                'sex' => Review::SEX_MALE
            ],
            [
                'id' => 3,
                'age' => 60,
                'sex' => Review::SEX_FEMALE
            ],
            [
                'id' => 4,
                'age' => 80,
                'sex' => Review::SEX_MALE
            ]
        ];

        $reviews = new ArrayCollection;

        foreach ($data as $row) {
            $reviews->add($reflectionHydrator->hydrate($row, new Review));
        }

        return $reviews;
    }

    public function testAgesCountCorrectAverageValue()
    {
        $agesService = new AgesService();
        $reviews = $this->createReviews();

        $femaleAverage = $agesService->getAverageAgeForReviews($reviews, Review::SEX_FEMALE);
        $maleAverage = $agesService->getAverageAgeForReviews($reviews, Review::SEX_MALE);

        $this->assertEquals($femaleAverage, 40);
        $this->assertEquals($maleAverage, 55);
    }
}