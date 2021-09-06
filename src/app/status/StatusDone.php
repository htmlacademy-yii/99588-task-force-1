<?php

namespace TaskForce\app\status;

class StatusDone extends Status
{
    const NAME = "выполнено";
    const KEY = "status_done";

    public function getName(): string
    {
        return self::NAME;
    }
    public function getKey(): string
    {
        return self::KEY;
    }
}
