<?php
namespace App\Listeners;

use App\Events\TaskCreated;
use App\Notifications\TaskNotification;
use Illuminate\Support\Facades\Notification;

class SendTaskCreatedNotification
{
    public function handle(TaskCreated $event)
    {
        $task = $event->task;

        // Notify task creator
        $task->user->notify(new TaskNotification($task, 'created'));

        // Notify assigned user if different from creator
        if ($task->assigned_user_id && $task->assigned_user_id !== $task->user_id) {
            $task->assignedUser->notify(new TaskNotification($task, 'created'));
        }
    }
}
