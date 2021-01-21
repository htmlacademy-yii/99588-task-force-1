<?php

require_once '../src/Task.php';

$task = new \taskForce\Task(1, 1);

assert($task->getNextStatus('action_cancel') === 'status_cancel', 'action_cancel');
assert($task->getNextStatus('action_respond') === 'status_process', 'action_respond');
assert($task->getNextStatus('action_done') === 'status_done', 'action_done');
assert($task->getNextStatus('action_failed') === 'status_failed', 'action_failed');

assert(empty(array_diff($task->getAvailableActions('status_new', 'employer'), ['action_cancel'])), 'status_new');
assert(empty(array_diff($task->getAvailableActions('status_cancel', 'employer'), [])), 'status_cancel');
assert(empty(array_diff($task->getAvailableActions('status_process', 'employer'), ['action_done'])), 'status_process');
assert(empty(array_diff($task->getAvailableActions('status_done', 'employer'), [])), 'status_done');
assert(empty(array_diff($task->getAvailableActions('status_failed', 'employer'), [])), 'status_failed');

assert(empty(array_diff($task->getAvailableActions('status_new', 'executor'), ['action_respond'])), 'status_new');
assert(empty(array_diff($task->getAvailableActions('status_cancel', 'executor'), [])), 'status_cancel');
assert(empty(array_diff($task->getAvailableActions('status_process', 'executor'), ['action_failed'])), 'status_process');
assert(empty(array_diff($task->getAvailableActions('status_done', 'executor'), [])), 'status_done');
assert(empty(array_diff($task->getAvailableActions('status_failed', 'executor'), [])), 'status_failed');
