<!-- resources/views/tasks/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex justify-center items-center">
    <div class="w-full max-w-lg bg-white shadow-md rounded p-6">
        <h1 class="text-3xl font-bold mb-6">Edit Task</h1>

        <form method="POST" action="{{ route('tasks.update', $task->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-semibold mb-2">Title</label>
                <input type="text" class="form-input w-full border-gray-300 rounded-lg p-2" id="title" name="title" value="{{ $task->title }}" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
                <textarea class="form-textarea w-full border-gray-300 rounded-lg p-2" id="description" name="description">{{ $task->description }}</textarea>
            </div>

            <div class="mb-4">
                <label for="due_date" class="block text-gray-700 font-semibold mb-2">Due Date</label>
                <input type="date" class="form-input w-full border-gray-300 rounded-lg p-2" id="due_date" name="due_date" value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}">
            </div>

            <div class="mb-4">
                <label for="priority" class="block text-gray-700 font-semibold mb-2">Priority</label>
                <select class="form-select w-full border-gray-300 rounded-lg p-2" id="priority" name="priority">
                    <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
                </select>
            </div>
            @if(auth()->user()->isAdmin())
            <div class="mb-4">
                <label for="assigned_user_id">Assign to:</label>
                <select name="assigned_user_id" id="assigned_user_id" class="form-control">
                    <option value="">Select User</option>
                    @foreach(\App\Models\User::all() as $user)
                        <option value="{{ $user->id }}" {{ old('assigned_user_id', $task->assigned_user_id ?? '') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none">Update Task</button>
                <a href="{{ route('tasks.index') }}" class="bg-red-500 text-white px-4 py-2 ml-2 rounded hover:bg-red-600 transition-colors duration-300">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
