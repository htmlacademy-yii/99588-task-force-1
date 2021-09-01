<?php

namespace TaskForce\app;

use TaskForce\app\action\Action;
use TaskForce\app\action\ActionCancel;
use TaskForce\app\action\ActionDone;
use TaskForce\app\action\ActionRefuse;
use TaskForce\app\action\ActionRespond;
use TaskForce\app\status\StatusCancel;
use TaskForce\app\status\StatusDone;
use TaskForce\app\status\StatusFailed;
use TaskForce\app\status\StatusNew;
use TaskForce\app\status\StatusProcess;

class Task
{
    private $errors = [];
    private $userId = NULL;
    private $employerId = NULL;
    private $executorId = NULL;
    private $currentStatus = NULL;

    private $actionRespond = NULL;
    private $actionRefuse = NULL;
    private $actionDone = NULL;
    private $actionCancel = NULL;

    private $statusNew = NULL;
    private $statusCancel = NULL;
    private $statusProcess = NULL;
    private $statusDone = NULL;
    private $statusFailed = NULL;

    public function __construct(int $userId, int $employerId, int $executorId) {
        $this->userId = $userId;
        $this->employerId = $employerId;
        $this->executorId = $executorId;

        $this->initActions();
        $this->initStatuses();
        $this->currentStatus = $this->statusNew;
    }

    private function initActions() {
        $this->actionRespond = new ActionRespond($this);
        $this->actionRefuse = new ActionRefuse($this);
        $this->actionDone = new ActionDone($this);
        $this->actionCancel = new ActionCancel($this);
    }

    private function initStatuses() {
        $this->statusNew = new StatusNew();
        $this->statusCancel = new StatusCancel();
        $this->statusProcess = new StatusProcess();
        $this->statusDone = new StatusDone();
        $this->statusFailed = new StatusFailed();
    }

    public function getActionsMap() {
        return [
            $this->actionRespond->getKey() => $this->actionRespond,
            $this->actionRefuse->getKey() => $this->actionRefuse,
            $this->actionDone->getKey() => $this->actionDone,
            $this->actionCancel->getKey() => $this->actionCancel,
        ];
    }

    public function getStatusesMap() {
        return [
            $this->statusNew->getKey() => $this->statusNew,
            $this->statusCancel->getKey() => $this->statusCancel,
            $this->statusProcess->getKey() => $this->statusProcess,
            $this->statusDone->getKey() => $this->statusDone,
            $this->statusFailed->getKey() => $this->statusFailed,
        ];
    }

    public function getNextStatus(Action $action) {
        switch ($action) {
            case $action instanceof ActionRespond:
                return $this->statusProcess;
            case $action instanceof ActionRefuse:
                return $this->statusFailed;
            case $action instanceof ActionDone:
                return $this->statusDone;
            case $action instanceof ActionCancel:
                return $this->statusCancel;
            default:
                return NULL;
        }
    }

    public function getAvailableAction() {
        switch (true) {
            case $this->currentStatus instanceof StatusNew && $this->actionCancel->checkAccess():
                return $this->actionCancel;
            case $this->currentStatus instanceof StatusNew && $this->actionRespond->checkAccess():
                return $this->actionRespond;
            case $this->currentStatus instanceof StatusProcess && $this->actionDone->checkAccess():
                return $this->actionDone;
            case $this->currentStatus instanceof StatusProcess && $this->actionRefuse->checkAccess():
                return $this->actionRefuse;
            default:
                return NULL;
        }
    }

    public function getErrors() {
        return $this->errors;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getEmployerId() {
        return $this->employerId;
    }

    public function getExecutorId() {
        return $this->executorId;
    }

    // для проверки getAvailableAction
    public function testSetStatus($status) {
        $this->currentStatus = $status;
    }
}
