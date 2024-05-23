<!-- resources/views/tasks/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex justify-center items-center">
    <div class="w-full max-w-md bg-white shadow-md rounded p-6">
        <h1 class="text-2xl font-bold mb-6">Create Task</h1>
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-semibold mb-2">Title</label>
                <input type="text" name="title" id="title" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
                <textarea name="description" id="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required></textarea>
            </div>
            <div class="mb-4">
                <label for="due_date" class="block text-gray-700 font-semibold mb-2">Due Date</label>
                <input type="date" name="due_date" id="due_date" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="priority" class="block text-gray-700 font-semibold mb-2">Priority</label>
                <select name="priority" id="priority" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
            </div>
            @if(auth()->user()->isAdmin())
            <!-- Assigned User Field -->
            <div class="mb-4">
                <label for="assigned_user_id" class="block text-gray-700 font-semibold mb-2">Assign to:</label>
                <select name="assigned_user_id" id="assigned_user_id" class="form-control w-full border-gray-300 rounded-lg p-2">
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
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none">Create Task</button>
                <a href="{{ route('tasks.index') }}" class="bg-red-500 text-white px-4 py-2 ml-2 rounded hover:bg-red-600 transition-colors duration-300">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
