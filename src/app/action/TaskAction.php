<?php

namespace TaskForce\app\action;

use TaskForce\app\Task;

abstract class TaskAction
{
    public abstract function getName():string;
    public abstract function getNameInternal():string;
    public abstract function checkAccess():bool;

    protected $task = NULL;

    public function __construct(Task $task) {
        $this->task = $task;
    }
}
