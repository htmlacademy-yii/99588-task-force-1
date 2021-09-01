<?php

namespace TaskForce\app\status;

abstract class Status
{
    public abstract function getName():string;
    public abstract function getKey():string;
}
