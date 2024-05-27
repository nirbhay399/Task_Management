<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Task;

class TaskMailNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $task;
    public $action;

    public function __construct(Task $task, $action)
    {
        $this->task = $task;
        $this->action = $action;
    }

    // public function build()
    // {
    //     return $this->subject("Task {$this->action}")
    //                 ->view('emails.task_notification')
    //                 ->with([
    //                     'taskTitle' => $this->task->title,
    //                     'taskAction' => $this->action,
    //                     'taskUrl' => url('/tasks/' . $this->task->id)
    //                 ]);
    // }

    public function build()
    {
        return $this->markdown('emails.task_notification')
                    ->subject("Task {$this->action}")
                    ->with([
                        'task' => $this->task,
                        'action' => $this->action,
                    ]);
    }
    
}
