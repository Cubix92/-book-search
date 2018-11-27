<?php

namespace Application\Factory;

use Application\Model\Book;
use Application\Service\AgesService;
use Application\Service\CompatibilityService;
use Application\Service\Statistic\StatisticParser;
use Application\Service\StatisticService;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;

class StatisticServiceFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): StatisticService
    {
        $bookRepository = $container->get(EntityManager::class)->getRepository(Book::class);
        $statisticParser = $container->get(StatisticParser::class);
        $compatibilityService = $container->get(CompatibilityService::class);
        $agesService = $container->get(AgesService::class);

        return new StatisticService($bookRepository, $statisticParser, $compatibilityService, $agesService);
    }
}