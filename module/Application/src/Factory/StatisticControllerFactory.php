<?php

namespace Application\Factory;

use Application\Controller\StatisticController;
use Application\Service\StatisticService;
use Interop\Container\ContainerInterface;

class StatisticControllerFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): StatisticController
    {
        $statisticService = $container->get(StatisticService::class);

        return new StatisticController($statisticService);
    }
}