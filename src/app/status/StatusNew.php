<?php

namespace TaskForce\app\status;

class StatusNew extends Status
{
    const NAME = "в работе";
    const KEY = "status_new";

    public function getName():string {
        return self::NAME;
    }
    public function getKey():string {
        return self::KEY;
    }
}
