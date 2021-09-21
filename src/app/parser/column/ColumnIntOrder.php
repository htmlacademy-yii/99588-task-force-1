<?php

namespace TaskForce\app\parser\column;

use TaskForce\app\exception\BaseException;

class ColumnIntOrder extends Column {
    const DEFAULT_START_VALUE = 1;
    private int $value = self::DEFAULT_START_VALUE;

    public function getValue() :string {
        return $this->value++;
    }
    public function setStartValue(int $startValue) :ColumnIntOrder {
        $this->value = $startValue;
        return $this;
    }
}
