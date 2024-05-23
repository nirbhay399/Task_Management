<?php

namespace App\Listeners;

use App\Events\TaskUpdated;
use App\Notifications\TaskNotification;
use Illuminate\Support\Facades\Notification;

class SendTaskUpdatedNotification
{
    public function handle(TaskUpdated $event)
    {
        $task = $event->task;

        // Notify task creator
        $task->user->notify(new TaskNotification($task, 'updated'));

        // Notify assigned user if different from creator
        if ($task->assigned_user_id && $task->assigned_user_id !== $task->user_id) {
            $task->assignedUser->notify(new TaskNotification($task, 'updated'));
        }
    }
}
