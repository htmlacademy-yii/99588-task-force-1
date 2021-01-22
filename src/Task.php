<?php

namespace taskForce;

class Task
{
    private $errors = [];
    private $currentStatus = NULL;
    private $employerId = NULL;
    private $executorId = NULL;

    const USER_ROLE_EMPLOYER = 'employer';
    const USER_ROLE_EXECUTOR = 'executor';

    const STATUS_NEW = 'status_new';
    const STATUS_CANCEL = 'status_cancel';
    const STATUS_PROCESS = 'status_process';
    const STATUS_DONE = 'status_done';
    const STATUS_FAILED = 'status_failed';

    const ACTION_CANCEL = 'action_cancel';
    const ACTION_RESPOND = 'action_respond';
    const ACTION_DONE = 'action_done';
    const ACTION_FAILED = 'action_failed';


    public function __construct(int $executorId, int $employerId) {
        $this->executorId = $executorId;
        $this->employerId = $employerId;
    }

    private $statusesMap = [
        'statuses' => [
            self::STATUS_NEW => 'новое',
            self::STATUS_CANCEL => 'отменено',
            self::STATUS_PROCESS => 'в работе',
            self::STATUS_DONE => 'выполнено',
            self::STATUS_FAILED => 'провалено'
        ],
        'actions' => [
            self::ACTION_CANCEL => 'отменить',
            self::ACTION_RESPOND => 'откликнуться',
            self::ACTION_DONE => 'выполнено',
            self::ACTION_FAILED => 'отказаться'
        ]
    ];

    private $nextStatus = [
        self::ACTION_CANCEL => self::STATUS_CANCEL,
        self::ACTION_DONE => self::STATUS_DONE,
        self::ACTION_RESPOND => self::STATUS_PROCESS,
        self::ACTION_FAILED => self::STATUS_FAILED
    ];

    private $availableActions = [
        self::USER_ROLE_EMPLOYER => [
            self::STATUS_NEW => [self::ACTION_CANCEL],
            self::STATUS_PROCESS => [self::ACTION_DONE]
        ],
        self::USER_ROLE_EXECUTOR => [
            self::STATUS_NEW => [self::ACTION_RESPOND],
            self::STATUS_PROCESS => [self::ACTION_FAILED]
        ]
    ];

    public function getErrors() {
        return $this->errors;
    }

    public function getStatusesMap() {
        return $this->statusesMap['statuses'];
    }

    public function getActionsMap() {
        return $this->statusesMap['actions'];
    }

    public function getNextStatus($action) {
        try {
            if (!isset($this->statusesMap['actions'][$action]))
                throw new \Exception("(${action}) action does not exist");
            return $this->nextStatus[$action] ?? NULL;
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
            return false;
        }
    }

    public function getAvailableActions($status, $userRole) {
        try {
            if (!isset($this->availableActions[$userRole]))
                throw new \Exception("(${userRole}) user role does not exist");
            if (!isset($this->statusesMap['statuses'][$status]))
                throw new \Exception("(${status}) status does not exist");
            return $this->availableActions[$userRole][$status] ?? [];
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
            return false;
        }
    }
}
