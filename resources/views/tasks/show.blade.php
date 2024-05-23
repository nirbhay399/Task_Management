<!-- resources/views/tasks/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex justify-center items-center">
    <div class="w-full max-w-2xl bg-white shadow-md rounded p-6">
        <h1 class="text-3xl font-bold mb-4">{{ $task->title }}</h1>
        <p class="text-gray-600 mb-4">{{ $task->description }}</p>
        <div class="mb-4">
            <span class="font-semibold">Due Date:</span> 
            <span class="text-gray-700">{{ $task->due_date }}</span>
        </div>
        <div class="mb-4">
            <span class="font-semibold">Priority:</span> 
            <span class="text-gray-700">{{ ucfirst($task->priority) }}</span>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('tasks.edit', $task->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none">Edit Task</a>
            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 focus:outline-none">Delete Task</button>
            </form>
        </div>
    </div>
</div>
@endsection
