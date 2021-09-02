<?php

namespace TaskForce\app\action;

class ActionCancel extends Action
{
    const NAME = "отменить";
    const KEY = "action_cancel";

    public function getName():string {
        return self::NAME;
    }
    public function getKey():string {
        return self::KEY;
    }
    public function checkAccess():bool {
        return $this->task->getUserId() === $this->task->getEmployerId();
    }
}
