<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Events\TaskEvent;
use App\Events\TaskUpdated;
use App\Events\TaskCreated;
use App\Events\TaskAssigned;

class TaskController extends Controller
{
    // public function index()
    // {
    //     $tasks = Auth::user()->tasks;
    //     return view('tasks.index', compact('tasks'));
    // }
    public function index(Request $request)
    {
        $query = Task::query();

        // Admins can see all tasks, others see only their assigned tasks
        if (Auth::user()->role !== 'admin') {
            $query->where(function($q) {
                $q->where('assigned_user_id', Auth::id());
                //   ->orWhere('user_id', Auth::id());
            });
        }

        // Implement filtering by task title or assigned user name
        if ($request->filled('filter_by')) {
            $filterBy = $request->input('filter_by');
            $query->where(function ($query) use ($filterBy) {
                $query->where('title', 'like', '%' . $filterBy . '%')
                      ->orWhereHas('assignedUser', function ($query) use ($filterBy) {
                          $query->where('name', 'like', '%' . $filterBy . '%');
                      });
            });
        }

        // Implement sorting, if provided via query parameters
        if ($request->filled('sort_by')) {
            $direction = $request->input('direction', 'asc');
            $query->orderBy($request->input('sort_by'), $direction);
        }

        $tasks = $query->get();

        return view('tasks.index', compact('tasks'));
    }


    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'assigned_user_id' => 'nullable|exists:users,id',
        ]);

        $data = $request->except('assigned_user_id');
        if (!$request->filled('assigned_user_id')) {
            $data['assigned_user_id'] = Auth::id();
        }
        $task = Auth::user()->tasks()->create($data);
        event(new TaskCreated($task));

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'assigned_user_id' => 'nullable|exists:users,id',
        ]);

        $task->update($request->all());
        event(new TaskUpdated($task));

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function assign(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $data = $request->validate([
            'assigned_user_id' => 'required|exists:users,id',
        ]);

        $task->update($data);

        event(new TaskAssigned($task));

        return redirect()->route('tasks.index')->with('success', 'Task assigned successfully.');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        
       $task->delete();
        event(new TaskEvent($task));

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
