<?php

namespace Application\Controller;

use Application\Service\StatisticService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class StatisticController extends AbstractActionController
{
    protected $statisticService;

    public function __construct(StatisticService $statisticService)
    {
        $this->statisticService = $statisticService;
    }

    public function showAction()
    {
        /**
         * gdyby wejscie pochodziło od użytkownika tutaj bym je przefiltrował i zwalidował,
         * dodatkowo tutaj tworzyłbym obiekt StatisticContainer przy pomocy parsera.
        */
        return new ViewModel([
            'firstResults' => $this->statisticService->showStatistics('ZieLoNa MiLa|age>30'),
            'secondResults' => $this->statisticService->showStatistics('ZiElonA Droga|age<30'),
        ]);
    }
}
