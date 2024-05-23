<?php

namespace App\Listeners;

use App\Events\TaskAssigned;
use App\Notifications\TaskNotification;
use Illuminate\Support\Facades\Notification;

class SendTaskAssignedNotification
{
    public function handle(TaskAssigned $event)
    {
        $task = $event->task;

        // Notify assigned user
        if ($task->assigned_user_id) {
            $task->assignedUser->notify(new TaskNotification($task, 'assigned'));
        }
    }
}
