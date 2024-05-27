<?php

namespace App\Listeners;

use App\Events\TaskAssigned;
use App\Notifications\TaskNotification;
use App\Mail\TaskMailNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;


class SendTaskAssignedNotification
{
    public function handle(TaskAssigned $event)
    {
        $task = $event->task;
        $taskOwnerEmail = $task->user->email;
        
        // Send email notification
        Mail::to($taskOwnerEmail)->send(new TaskMailNotification($task, 'assigned'));
        // Notify assigned user
        if ($task->assigned_user_id) {
            $task->assignedUser->notify(new TaskNotification($task, 'assigned'));
        }        
    }
}
