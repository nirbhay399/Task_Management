<?php
namespace App\Listeners;

use App\Events\TaskEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class TaskEventListener
{
    public function __construct()
    {
        //
    }

    // public function handle(TaskEvent $event)
    // {
    //     Notification::send($event->task->user, new TaskNotification($event->task));
    // }
    public function handle(TaskEvent $event)
    {
        $task = $event->task;
        $taskOwnerEmail = $task->user->email;

        // Send email notification
        Mail::to($taskOwnerEmail)->send(new TaskNotification($task));

        // Create in-app notification
        $task->user->notify(new TaskNotification($task));

        // Send notification using Laravel's Notification facade
        Notification::send($task->user, new TaskNotification($task));
    }

}
