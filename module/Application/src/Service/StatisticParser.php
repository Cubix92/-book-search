<?php

namespace Application\Service;

class StatisticParser
{
    const BOTTOM_RANGE = '<';

    private $container;

    public function parse(string $parameter): StatisticContainer
    {
        $this->container = new StatisticContainer();
        $parameters = explode('|', $parameter);

        $this->prepareName($parameters[0]);
        $this->prepareAge($parameters[1]);

        return $this->container;
    }

    protected function prepareName(string $nameParam): void
    {
        $this->container['name'] = strtolower($nameParam);
    }

    protected function prepareAge(string $ageParam): void
    {
        $charactersSet = str_split($ageParam);
        $result = 0;

        foreach($charactersSet as &$character) {
            if (is_numeric($character)) {
                $result .= $character;
            }
        }

        if (strstr($ageParam, self::BOTTOM_RANGE)) {
            $this->container['maxAge'] = (int) $result;
        } else {
            $this->container['minAge'] = (int) $result;
        }
    }
};