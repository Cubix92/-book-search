<?php

namespace ApplicationTest\Controller;

use Application\Controller\StatisticController;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class StatisticControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = false;

    public function setUp()
    {
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();
    }

    public function testShowActionCanBeAccessed()
    {
        $this->dispatch('/');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Application');
        $this->assertControllerName(StatisticController::class);
        $this->assertControllerClass('StatisticController');
        $this->assertMatchedRouteName('home');
    }
}