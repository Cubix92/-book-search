<?php

namespace ApplicationTest\Model;

use Application\Model\Book;
use Application\Model\Review;
use PHPUnit\Framework\TestCase;
use Zend\Hydrator\Reflection;

class ReviewTest extends TestCase
{
    protected function createReview(): Review
    {
        $reflectionHydrator = new Reflection;

        $bookData = [
            'id' => 1,
            'name' => 'The Hobbit or There and Back Again',
            'bookDate' => new \DateTime('1937-09-21')
        ];

        /** @var Book $book */
        $book = $reflectionHydrator->hydrate($bookData, new Book);

        $data = [
            'id' => 1,
            'age' => 26,
            'sex' => Review::SEX_FEMALE,
            'book' => $book
        ];

        $review = $reflectionHydrator->hydrate($data, new Review);

        return $review;
    }

    public function testEntityGetsPropertiesCorrectly()
    {
        $reivew = $this->createReview();

        $this->assertInternalType('int', $reivew->getId());
        $this->assertInternalType('int', $reivew->getAge());
        $this->assertInternalType('string', $reivew->getSex());
        $this->assertInstanceOf(Book::class, $reivew->getBook());
        $this->assertEquals(Review::SEX_FEMALE, $reivew->getSex());
        $this->assertNotEquals(Review::SEX_MALE, $reivew->getSex());
    }
}