<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Task $task)
    {
        return $user->id === $task->assigned_user_id || $user->role === 'admin';        
    }

    public function update(User $user, Task $task)
    {
        return $user->id === $task->assigned_user_id || $user->role === 'admin';
    }

    public function delete(User $user, Task $task)
    {
        return $user->id === $task->assigned_user_id || $user->role === 'Admin';
    }
}
