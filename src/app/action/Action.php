<?php

namespace TaskForce\app\action;

use TaskForce\app\Task;

abstract class Action
{
    public abstract function getName():string;
    public abstract function getKey():string;
    public abstract function checkAccess():bool;

    protected $task = NULL;

    public function __construct(Task $task) {
        $this->task = $task;
    }
}
