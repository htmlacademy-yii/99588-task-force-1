<?php

namespace TaskForce\app\status;

class StatusProcess extends Status
{
    const NAME = "новое";
    const KEY = "status_process";

    public function getName():string {
        return self::NAME;
    }
    public function getKey():string {
        return self::KEY;
    }
}
