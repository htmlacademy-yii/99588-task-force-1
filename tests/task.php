<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use TaskForce\app\Task;
use TaskForce\app\status\StatusCancel;
use TaskForce\app\status\StatusDone;
use TaskForce\app\status\StatusFailed;
use TaskForce\app\status\StatusNew;
use TaskForce\app\status\StatusProcess;
use TaskForce\app\action\ActionCancel;
use TaskForce\app\action\ActionDone;
use TaskForce\app\action\ActionRefuse;
use TaskForce\app\action\ActionRespond;

$taskEmployer = new Task(1, 1, 2);
$taskExecutor = new Task(2, 1, 2);

$actionRespond = new ActionRespond($taskEmployer);
$actionRefuse = new ActionRefuse($taskEmployer);
$actionDone = new ActionDone($taskEmployer);
$actionCancel = new ActionCancel($taskEmployer);

$statusNew = new StatusNew();
$statusCancel = new StatusCancel();
$statusProcess = new StatusProcess();
$statusDone = new StatusDone();
$statusFailed = new StatusFailed();

var_dump(assert($taskEmployer->getNextStatus($actionCancel) instanceof StatusCancel));
var_dump(assert($taskEmployer->getNextStatus($actionRespond) instanceof StatusProcess));
var_dump(assert($taskEmployer->getNextStatus($actionDone) instanceof StatusDone));
var_dump(assert($taskEmployer->getNextStatus($actionRefuse) instanceof StatusFailed));

var_dump(assert($taskEmployer->getAvailableAction() instanceof ActionCancel));
var_dump(assert($taskExecutor->getAvailableAction() instanceof ActionRespond));

$taskEmployer->testSetStatus($statusProcess);
$taskExecutor->testSetStatus($statusProcess);

var_dump(assert($taskEmployer->getAvailableAction() instanceof ActionDone));
var_dump(assert($taskExecutor->getAvailableAction() instanceof ActionRefuse));

$taskEmployer->testSetStatus($statusCancel);
$taskExecutor->testSetStatus($statusCancel);

var_dump(assert($taskEmployer->getAvailableAction() === NULL));
var_dump(assert($taskExecutor->getAvailableAction() === NULL));

$taskEmployer->testSetStatus($statusDone);
$taskExecutor->testSetStatus($statusDone);

var_dump(assert($taskEmployer->getAvailableAction() === NULL));
var_dump(assert($taskExecutor->getAvailableAction() === NULL));

$taskEmployer->testSetStatus($statusFailed);
$taskExecutor->testSetStatus($statusFailed);

var_dump(assert($taskEmployer->getAvailableAction() === NULL));
var_dump(assert($taskExecutor->getAvailableAction() === NULL));
