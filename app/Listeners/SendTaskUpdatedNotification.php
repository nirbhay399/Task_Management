<?php

namespace App\Listeners;

use App\Events\TaskUpdated;
use App\Notifications\TaskNotification;
use App\Mail\TaskMailNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendTaskUpdatedNotification
{
    public function handle(TaskUpdated $event)
    {
        $task = $event->task;
        $taskOwnerEmail = $task->user->email;
        
        // Send email notification
        Mail::to($taskOwnerEmail)->send(new TaskMailNotification($task, 'updated'));

        // Notify task creator
        $task->user->notify(new TaskNotification($task, 'updated'));

        // Notify assigned user if different from creator
        if ($task->assigned_user_id && $task->assigned_user_id !== $task->user_id) {
            $task->assignedUser->notify(new TaskNotification($task, 'updated'));
        }
    }
}
