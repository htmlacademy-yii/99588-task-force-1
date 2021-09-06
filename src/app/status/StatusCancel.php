<?php

namespace TaskForce\app\status;

class StatusCancel extends Status
{
    const NAME = "отменено";
    const KEY = "status_cancel";

    public function getName(): string
    {
        return self::NAME;
    }
    public function getKey(): string
    {
        return self::KEY;
    }
}
