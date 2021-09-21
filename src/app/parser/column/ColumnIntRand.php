<?php

namespace TaskForce\app\parser\column;

use TaskForce\app\exception\BaseException;

class ColumnIntRand extends Column {
    const DEFAULT_MIN_VALUE = 1;
    const DEFAULT_MAX_VALUE = 999;
    private int $minValue = self::DEFAULT_MIN_VALUE;
    private int $maxValue = self::DEFAULT_MAX_VALUE;

    public function getValue() :string {
        $rand = rand($this->minValue, $this->maxValue);
        return (string) isset($this->modifyFunction) ? call_user_func($this->modifyFunction, $rand) : $rand;
    }
    public function setMinValue(int $minValue) :ColumnIntRand {
        $this->minValue = $minValue;
        return $this;
    }
    public function setMaxValue(int $maxValue) :ColumnIntRand {
        $this->maxValue = $maxValue;
        return $this;
    }
}
