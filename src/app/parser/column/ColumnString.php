<?php

namespace TaskForce\app\parser\column;

use TaskForce\app\exception\BaseException;

class ColumnString extends Column {
    const DEFAULT_CUT_POSTFIX = "...";
    const DEFAULT_MARGIN = 4;
    private string $valueCutPostfix = self::DEFAULT_CUT_POSTFIX;
    private int $maxValueLen;
    private string $value;

    public function getValue() :string
    {
        if (isset($this->maxValueLen)) {
            $this->cutValueLen();
        }
        return is_callable($this->modifyFunction) ? call_user_func($this->modifyFunction, $this->value) : $this->value;
    }

    public function setValue(string $value) :ColumnString
    {
        $this->value = $value;
        return $this;
    }

    public function setMaxValueLen(int $maxValueLen) :ColumnString
    {
        $this->maxValueLen = $maxValueLen;
        return $this;
    }

    private function cutValueLen() :ColumnString
    {
        $len = strlen($this->value);

        if ($len > $this->maxValueLen + strlen(self::DEFAULT_MARGIN)) {
            $cutLen = $this->maxValueLen - $len - strlen($this->valueCutPostfix) - self::DEFAULT_MARGIN;
            $this->value = substr($this->value, 0, $cutLen) . $this->valueCutPostfix;
        }
        return $this;
    }
}
