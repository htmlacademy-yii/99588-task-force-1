<?php

namespace TaskForce\app\status;

class StatusFailed extends Status
{
    const NAME = "провалено";
    const KEY = "status_failed";

    public function getName(): string
    {
        return self::NAME;
    }
    public function getKey(): string
    {
        return self::KEY;
    }
}
