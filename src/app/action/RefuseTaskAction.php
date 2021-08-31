<?php

namespace TaskForce\app\action;

class RefuseTaskAction extends TaskAction
{
    const NAME = "отказаться";
    const NAME_INTERNAL = "action_refuse";

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
