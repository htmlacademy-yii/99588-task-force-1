<?php

namespace TaskForce\app\action;

class DoneTaskAction extends TaskAction
{
    const NAME = "выполнено";
    const NAME_INTERNAL = "action_done";

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
