<?php

namespace TaskForce\app;

use TaskForce\app\action\CancelTaskAction;
use TaskForce\app\action\DoneTaskAction;
use TaskForce\app\action\RefuseTaskAction;
use TaskForce\app\action\RespondTaskAction;

class Task
{
    const ACTION_RESPOND = "action_respond";
    const ACTION_REFUSE = "action_refuse";
    const ACTION_DONE = "action_done";
    const ACTION_CANCEL = "action_cancel";

    const STATUS_NEW = "status_new";
    const STATUS_CANCEL = "status_cancel";
    const STATUS_PROCESS = "status_process";
    const STATUS_DONE = "status_done";
    const STATUS_FAILED = "status_failed";

    private $errors = [];
    private $userId = NULL;
    private $employerId = NULL;
    private $executorId = NULL;

    private $actionsMap = NULL;
    private $currentStatus = self::STATUS_NEW;

    private $statusesMap = [
        self::STATUS_NEW => "новое",
        self::STATUS_CANCEL => "отменено",
        self::STATUS_PROCESS => "в работе",
        self::STATUS_DONE => "выполнено",
        self::STATUS_FAILED => "провалено"
    ];

    private $nextStatus = [
        self::ACTION_CANCEL => self::STATUS_CANCEL,
        self::ACTION_DONE => self::STATUS_DONE,
        self::ACTION_RESPOND => self::STATUS_PROCESS,
        self::ACTION_REFUSE => self::STATUS_FAILED
    ];

    private function initActionsMap() {
        $this->actionsMap = [
            self::ACTION_RESPOND => new RespondTaskAction($this),
            self::ACTION_REFUSE => new RefuseTaskAction($this),
            self::ACTION_DONE => new DoneTaskAction($this),
            self::ACTION_CANCEL => new CancelTaskAction($this)
        ];
    }

    public function __construct(int $userId, int $employerId, int $executorId) {
        $this->userId = $userId;
        $this->employerId = $employerId;
        $this->executorId = $executorId;

        $this->initActionsMap();
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

    public function getStatusesMap() {
        return $this->statusesMap;
    }

    public function getActionsMap() {
        return $this->actionsMap;
    }

    public function getNextStatus($action) {
        try {
            if (!isset($this->actionsMap[$action])) {
                throw new \Exception("(${action}) action does not exist");
            }
            return $this->nextStatus[$action] ?? NULL;
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
            return false;
        }
    }

    public function getAvailableAction() {
        switch (true) {
            case $this->currentStatus === self::STATUS_NEW && $this->actionsMap[self::ACTION_CANCEL]->checkAccess():
                return $this->actionsMap[self::ACTION_CANCEL];
                break;
            case $this->currentStatus === self::STATUS_NEW && $this->actionsMap[self::ACTION_RESPOND]->checkAccess():
                return $this->actionsMap[self::ACTION_RESPOND];
                break;
            case $this->currentStatus === self::STATUS_PROCESS && $this->actionsMap[self::ACTION_DONE]->checkAccess():
                return $this->actionsMap[self::ACTION_DONE];
                break;
            case $this->currentStatus === self::STATUS_PROCESS && $this->actionsMap[self::ACTION_REFUSE]->checkAccess():
                return $this->actionsMap[self::ACTION_REFUSE];
            default:
                return NULL;
        }
    }

    // для проверки getAvailableAction
    public function testSetStatus($status) {
        $this->currentStatus = $status;
    }
}
