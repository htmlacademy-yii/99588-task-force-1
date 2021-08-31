<?php

namespace TaskForce\app\action;

class RespondTaskAction extends TaskAction
{
    const NAME = "откликнуться";
    const NAME_INTERNAL = "action_respond";

    public function getName():string {
        return self::NAME;
    }
    public function getNameInternal():string {
        return self::NAME_INTERNAL;
    }
    public function checkAccess():bool {
        return $this->task->getUserId() === $this->task->getExecutorId();
    }
}
