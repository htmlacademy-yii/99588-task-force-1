<?php

namespace TaskForce\app;

use TaskForce\app\action\Action;
use TaskForce\app\action\ActionCancel;
use TaskForce\app\action\ActionDone;
use TaskForce\app\action\ActionRefuse;
use TaskForce\app\action\ActionRespond;
use TaskForce\app\status\Status;
use TaskForce\app\status\StatusCancel;
use TaskForce\app\status\StatusDone;
use TaskForce\app\status\StatusFailed;
use TaskForce\app\status\StatusNew;
use TaskForce\app\status\StatusProcess;
use TaskForce\app\exception\BaseException;

class Task
{
    private int $userId;
    private int $employerId;
    private ?int $executorId;
    private Status $currentStatus;

    private Action $actionRespond;
    private Action $actionRefuse;
    private Action $actionDone;
    private Action $actionCancel;

    private Status $statusNew;
    private Status $statusCancel;
    private Status $statusProcess;
    private Status $statusDone;
    private Status $statusFailed;

    public function __construct(string $status, int $userId, int $employerId, ?int $executorId = NULL)
    {
        $this->userId = $userId;
        $this->employerId = $employerId;
        $this->executorId = $executorId;

        $this->initActions();
        $this->initStatuses();

        if (! isset($this->getStatusesMap()[$status])) {
            throw new BaseException("invalid status");
        }
        $this->currentStatus = $this->getStatusesMap()[$status];
    }

    private function initActions(): void
    {
        $this->actionRespond = new ActionRespond($this);
        $this->actionRefuse = new ActionRefuse($this);
        $this->actionDone = new ActionDone($this);
        $this->actionCancel = new ActionCancel($this);
    }

    private function initStatuses(): void
    {
        $this->statusNew = new StatusNew();
        $this->statusCancel = new StatusCancel();
        $this->statusProcess = new StatusProcess();
        $this->statusDone = new StatusDone();
        $this->statusFailed = new StatusFailed();
    }

    public function getActionsMap(): array
    {
        return [
            $this->actionRespond->getKey() => $this->actionRespond,
            $this->actionRefuse->getKey() => $this->actionRefuse,
            $this->actionDone->getKey() => $this->actionDone,
            $this->actionCancel->getKey() => $this->actionCancel,
        ];
    }

    public function getStatusesMap(): array
    {
        return [
            $this->statusNew->getKey() => $this->statusNew,
            $this->statusCancel->getKey() => $this->statusCancel,
            $this->statusProcess->getKey() => $this->statusProcess,
            $this->statusDone->getKey() => $this->statusDone,
            $this->statusFailed->getKey() => $this->statusFailed,
        ];
    }

    public function getNextStatus(string $action): Status
    {
        switch ($action) {
            case $this->actionRespond->getKey():
                return $this->statusProcess;
            case $this->actionRefuse->getKey():
                return $this->statusFailed;
            case $this->actionDone->getKey():
                return $this->statusDone;
            case $this->actionCancel->getKey():
                return $this->statusCancel;
            default:
                throw new BaseException("no status available");
        }
    }

    public function getAvailableAction(): Action
    {
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
                throw new BaseException("no action available");
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getEmployerId(): int
    {
        return $this->employerId;
    }

    public function getExecutorId(): int
    {
        return $this->executorId;
    }
}
