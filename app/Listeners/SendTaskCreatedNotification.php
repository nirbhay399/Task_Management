<?php
namespace App\Listeners;

use App\Events\TaskCreated;
use App\Notifications\TaskNotification;
use App\Mail\TaskMailNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendTaskCreatedNotification
{
    public function handle(TaskCreated $event)
    {
        $task = $event->task;

        $taskOwnerEmail = $task->user->email;
        
        // Send email notification
        Mail::to($taskOwnerEmail)->send(new TaskMailNotification($task, 'created'));
        // Notify task creator
        $task->user->notify(new TaskNotification($task, 'created'));

        // Notify assigned user if different from creator
        if ($task->assigned_user_id && $task->assigned_user_id !== $task->user_id) {
            $task->assignedUser->notify(new TaskNotification($task, 'created'));
        }
    }
}
