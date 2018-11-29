<?php

namespace ApplicationTest\Model;

use Application\Model\Book;
use Application\Model\Review;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Zend\Hydrator\Reflection;

class BookTest extends TestCase
{
    protected function createBook(): Book
    {
        $reflectionHydrator = new Reflection;

        $firstReviewData = [
            'id' => 1,
            'age' => 26,
            'sex' => 'f'
        ];

        $firstReview = $reflectionHydrator->hydrate($firstReviewData, new Review);

        $secondReviewData = [
            'id' => 2,
            'age' => 28,
            'sex' => 'm'
        ];

        $secondReview = $reflectionHydrator->hydrate($secondReviewData, new Review);

        $reviewsCollection = new ArrayCollection;
        $reviewsCollection->add($firstReview);
        $reviewsCollection->add($secondReview);

        $data = [
            'id' => 1,
            'name' => 'The Hobbit or There and Back Again',
            'bookDate' => new \DateTime('1937-09-21'),
            'reviews' => $reviewsCollection
        ];

        /** @var Book $book */
        $book = $reflectionHydrator->hydrate($data, new Book);

        return $book;
    }

    public function testEntityGetsPropertiesCorrectly()
    {
        $book = $this->createBook();

        $this->assertInternalType('int', $book->getId());
        $this->assertInternalType('string', $book->getName());
        $this->assertInstanceOf(\DateTime::class, $book->getBookDate());
        $this->assertEquals('1937-09-21', $book->getBookDate()->format('Y-m-d'));
    }
}