<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use TaskForce\app\Task;
use TaskForce\app\action\CancelTaskAction;
use TaskForce\app\action\DoneTaskAction;
use TaskForce\app\action\RefuseTaskAction;
use TaskForce\app\action\RespondTaskAction;

$taskEmployer = new Task(1, 1, 2);
$taskExecutor = new Task(2, 1, 2);

const ACTION_RESPOND = "action_respond";
const ACTION_REFUSE = "action_refuse";
const ACTION_DONE = "action_done";
const ACTION_CANCEL = "action_cancel";

const STATUS_NEW = "status_new";
const STATUS_CANCEL = "status_cancel";
const STATUS_PROCESS = "status_process";
const STATUS_DONE = "status_done";
const STATUS_FAILED = "status_failed";

var_dump(assert($taskEmployer->getNextStatus(ACTION_CANCEL) === STATUS_CANCEL, ACTION_CANCEL));
var_dump(assert($taskEmployer->getNextStatus(ACTION_RESPOND) === STATUS_PROCESS, ACTION_RESPOND));
var_dump(assert($taskEmployer->getNextStatus(ACTION_DONE) === STATUS_DONE, ACTION_DONE));
var_dump(assert($taskEmployer->getNextStatus(ACTION_REFUSE) === STATUS_FAILED, ACTION_REFUSE));

var_dump(assert($taskEmployer->getAvailableAction() instanceof CancelTaskAction));
var_dump(assert($taskExecutor->getAvailableAction() instanceof RespondTaskAction));

$taskEmployer->testSetStatus(STATUS_PROCESS);
$taskExecutor->testSetStatus(STATUS_PROCESS);

var_dump(assert($taskEmployer->getAvailableAction() instanceof DoneTaskAction));
var_dump(assert($taskExecutor->getAvailableAction() instanceof RefuseTaskAction));

$taskEmployer->testSetStatus(STATUS_DONE);
$taskExecutor->testSetStatus(STATUS_DONE);

var_dump(assert($taskEmployer->getAvailableAction() === NULL));
var_dump(assert($taskExecutor->getAvailableAction() === NULL));

$taskEmployer->testSetStatus(STATUS_CANCEL);
$taskExecutor->testSetStatus(STATUS_CANCEL);

var_dump(assert($taskEmployer->getAvailableAction() === NULL));
var_dump(assert($taskExecutor->getAvailableAction() === NULL));

$taskEmployer->testSetStatus(STATUS_FAILED);
$taskExecutor->testSetStatus(STATUS_FAILED);

var_dump(assert($taskEmployer->getAvailableAction() === NULL));
var_dump(assert($taskExecutor->getAvailableAction() === NULL));
