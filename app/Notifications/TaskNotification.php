<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;
    protected $action;

    public function __construct($task, $action)
    {
        $this->task = $task;
        $this->action = $action;
    }

    public function via($notifiable)
    {
        $channels = ['database'];

        // Check if mail configuration is set
        if (config('mail.username') && config('mail.password')) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    public function toMail($notifiable)
    {
        $message = (new MailMessage)
                    ->subject("Task {$this->action}")
                    ->line("A task has been {$this->action}.")
                    ->action('View Task', url('/tasks/' . $this->task->id))
                    ->line('Thank you for using our application!');

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'action' => $this->action,
        ];
    }
}
