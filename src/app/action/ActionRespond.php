<?php

namespace TaskForce\app\action;

class ActionRespond extends Action
{
    const NAME = "откликнуться";
    const KEY = "action_respond";

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
