<?php

namespace TaskForce\app\action;

class ActionDone extends Action
{
    const NAME = "выполнено";
    const KEY = "action_done";

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
