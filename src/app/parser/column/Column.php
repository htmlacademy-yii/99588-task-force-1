<?php

namespace TaskForce\app\parser\column;

abstract class Column {
    private string $key;
    protected string $modifyFunction;

    public function __construct(string $key) {
        $this->key = $key;
    }
    public function getKey() :string {
        return $this->key;
    }
    public function setModifyFunction(callable $function) :Column
    {
        $this->modifyFunction = $function;
        return $this;
    }
    public abstract function getValue() :string;
}
