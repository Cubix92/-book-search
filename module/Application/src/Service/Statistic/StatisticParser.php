<?php

namespace Application\Service\Statistic;

class StatisticParser
{
    const BOTTOM_RANGE = '<';

    public function parse(string $parameter): StatisticParameters
    {
        $statisticParameters = new StatisticParameters();
        $stringParameters = explode('|', $parameter);

        $this->prepareName($statisticParameters, $stringParameters[0]);
        $this->prepareAge($statisticParameters, $stringParameters[1]);

        return $statisticParameters;
    }

    protected function prepareName(StatisticParameters $container, string $nameParam): void
    {
        $container['name'] = strtolower($nameParam);
    }

    protected function prepareAge(StatisticParameters $container, string $ageParam): void
    {
        $charactersSet = str_split($ageParam);
        $result = 0;

        foreach($charactersSet as &$character) {
            if (is_numeric($character)) {
                $result .= $character;
            }
        }

        if (strstr($ageParam, self::BOTTOM_RANGE)) {
            $container['maxAge'] = (int) $result;
        } else {
            $container['minAge'] = (int) $result;
        }
    }
};