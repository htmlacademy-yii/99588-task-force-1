<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

const STATUS_NEW = 'status_new';
const STATUS_CANCEL = 'status_cancel';
const STATUS_PROCESS = 'status_process';
const STATUS_DONE = 'status_done';
const STATUS_FAILED = 'status_failed';

const ACTION_CANCEL = 'action_cancel';
const ACTION_RESPOND = 'action_respond';
const ACTION_DONE = 'action_done';
const ACTION_REFUSE = 'action_refuse';

use TaskForce\app\exception\BaseException;
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

try {
    $taskEmployerStatusNew = new Task(STATUS_NEW, 1, 1, 2);
    $taskExecutorStatusNew = new Task(STATUS_NEW, 2, 1, 2);

    $taskEmployerStatusProcess = new Task(STATUS_PROCESS, 1, 1, 2);
    $taskExecutorStatusProcess = new Task(STATUS_PROCESS, 2, 1, 2);

    var_dump(assert($taskEmployerStatusNew->getNextStatus(ACTION_CANCEL) instanceof StatusCancel));
    var_dump(assert($taskEmployerStatusNew->getNextStatus(ACTION_RESPOND) instanceof StatusProcess));
    var_dump(assert($taskEmployerStatusNew->getNextStatus(ACTION_DONE) instanceof StatusDone));
    var_dump(assert($taskEmployerStatusNew->getNextStatus(ACTION_REFUSE) instanceof StatusFailed));

    var_dump(assert($taskEmployerStatusNew->getAvailableAction() instanceof ActionCancel));
    var_dump(assert($taskExecutorStatusNew->getAvailableAction() instanceof ActionRespond));

    var_dump(assert($taskEmployerStatusProcess->getAvailableAction() instanceof ActionDone));
    var_dump(assert($taskExecutorStatusProcess->getAvailableAction() instanceof ActionRefuse));
}
catch (BaseException $e) {
    var_dump($e->getMessage());
}
