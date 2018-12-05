<?php

namespace ApplicationTest\Model;

use Application\Model\Book;
use Application\Repository\BookRepository;
use Application\Service\Statistic\StatisticParameters;
use Application\Service\Statistic\StatisticParser;
use Application\Service\StatisticService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Prophecy\Argument;
use Zend\Hydrator\Reflection;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class StatisticServiceTest extends AbstractHttpControllerTestCase
{
    /** @var StatisticParser $statisticParser */
    protected $statisticParser;

    /** @var EntityManager $entityManager */
    protected $entityManager;

    /** @var BookRepository $bookRepository */
    protected $bookRepository;

    protected function createBook(): Book
    {
        $reflectionHydrator = new Reflection;

        $data = [
            'id' => 1,
            'name' => 'The Hobbit or There and Back Again',
            'bookDate' => new \DateTime('1937-09-21'),
            'reviews' => new ArrayCollection()
        ];

        /** @var Book $book */
        $book = $reflectionHydrator->hydrate($data, new Book);

        return $book;
    }

    protected function setUp()
    {
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();

        $this->statisticParser = $this->prophesize(StatisticParser::class);
        $this->entityManager = $this->prophesize(EntityManager::class);
        $this->bookRepository = $this->prophesize(BookRepository::class);

        $services = $this->getApplicationServiceLocator();

        $services->setAllowOverride(true);
        $services->setService(StatisticParser::class, $this->statisticParser->reveal());
        $services->setService(EntityManager::class, $this->entityManager->reveal());
        $services->setAllowOverride(false);
    }

    public function testServiceShowsCorrectlyStatistics()
    {
        $books = [$this->createBook()];

        $statisticParametersFake = new StatisticParameters();
        $statisticParametersFake['name'] = "sample_name";

        $this->statisticParser->parse('ZieLoNa MiLa|age>30')->willReturn($statisticParametersFake);
        $this->entityManager->getRepository(Book::class)->willReturn($this->bookRepository);
        $this->bookRepository->searchForStatistics($statisticParametersFake)->willReturn($books);

        $this->statisticParser->parse(Argument::type('string'))->shouldBeCalled();
        $this->bookRepository->searchForStatistics(Argument::type(StatisticParameters::class))->shouldBeCalled();

        $statisticService = $this->getApplicationServiceLocator()->get(StatisticService::class);
        $this->assertInternalType('array', $statisticService->showStatistics('ZieLoNa MiLa|age>30'));
    }
}