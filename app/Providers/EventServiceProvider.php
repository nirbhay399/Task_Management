<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\TaskCreated;
use App\Events\TaskUpdated;
use App\Events\TaskAssigned;
use App\Listeners\SendTaskCreatedNotification;
use App\Listeners\SendTaskUpdatedNotification;
use App\Listeners\SendTaskAssignedNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        TaskEvent::class => [
            TaskEventListener::class,
        ],
        TaskCreated::class => [
            SendTaskCreatedNotification::class,
        ],
        TaskUpdated::class => [
            SendTaskUpdatedNotification::class,
        ],
        TaskAssigned::class => [
            SendTaskAssignedNotification::class,
        ],
    ];    

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
