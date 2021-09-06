<?php

namespace TaskForce\app\action;

class ActionRefuse extends Action
{
    const NAME = "отказаться";
    const KEY = "action_refuse";

    public function getName(): string
    {
        return self::NAME;
    }
    public function getKey(): string
    {
        return self::KEY;
    }
    public function checkAccess(): bool
    {
        return $this->task->getUserId() === $this->task->getExecutorId();
    }
}
