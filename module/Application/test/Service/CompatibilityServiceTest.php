<?php

namespace ApplicationTest\Model;

use Application\Service\CompatibilityService;
use PHPUnit\Framework\TestCase;

class CompatibilityServiceTest extends TestCase
{
    public function testCompatibilityShowCorrectPercentage()
    {
        $compatibilityService = new CompatibilityService();

        $firstPhrase = 'ABCD';
        $secondPhrase = 'EFGH';
        $thirdPhrase = 'ABGH';

        $identityPhrases = $compatibilityService->getCompatibilityOf($firstPhrase, $firstPhrase);
        $differentPhrases = $compatibilityService->getCompatibilityOf($firstPhrase, $secondPhrase);
        $similarPhrases = $compatibilityService->getCompatibilityOf($firstPhrase, $thirdPhrase);

        $this->assertEquals($identityPhrases, 100);
        $this->assertEquals($differentPhrases, 0);
        $this->assertEquals($similarPhrases, 50);
    }
}