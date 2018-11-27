<?php

namespace Application\Service\Statistic;

use ArrayAccess;

final class StatisticParameters implements ArrayAccess
{
    private $container = [];

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    public function filter(Callable $filter): StatisticParameters
    {
        $copyContainer = clone($this);

        foreach ($copyContainer->container as $key => $value) {
            $copyContainer->container[$key] = $filter($key, $value);
        }

        return $copyContainer;
    }
}