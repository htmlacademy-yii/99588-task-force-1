<?php

namespace TaskForce\app\action;

class CancelTaskAction extends TaskAction
{
    const NAME = "отменить";
    const NAME_INTERNAL = "action_cancel";

    public function getName():string {
        return self::NAME;
    }
    public function getNameInternal():string {
        return self::NAME_INTERNAL;
    }
    public function checkAccess():bool {
        return $this->task->getUserId() === $this->task->getEmployerId();
    }
}
