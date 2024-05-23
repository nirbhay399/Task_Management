@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">Tasks</h1>
        <a href="{{ route('tasks.create') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors duration-300">Create Task</a>
    </div>

    <form action="{{ route('tasks.index') }}" method="GET" class="mb-4 flex space-x-4">
        <div class="flex space-x-2">
            <label for="sort_by" class="block text-gray-700">Sort by:</label>
            <select name="sort_by" id="sort_by" class="form-select border-gray-300 rounded-lg">
                <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Title</option>
                <option value="due_date" {{ request('sort_by') == 'due_date' ? 'selected' : '' }}>Due Date</option>
            </select>
            <select name="direction" id="direction" class="form-select border-gray-300 rounded-lg">
                <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
            </select>
        </div>
        <div class="flex space-x-2">
            <label for="filter_by" class="block text-gray-700">Filter by:</label>
            <input type="text" name="filter_by" id="filter_by" placeholder="Task Name / UserName" value="{{ request('filter_by') }}" class="form-input border-gray-300 rounded-lg">
            <button type="submit" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Search</button>
        </div>
    </form>

    @if (is_null($tasks) || $tasks->isEmpty())
        <p class="text-gray-600">No tasks found.</p>
    @else
        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3 px-6">Tasks</th>
                        <th scope="col" class="py-3 px-6">Due Date</th>
                        @if(Auth::user()->role === 'admin')
                            <th scope="col" class="py-3 px-6">Assigned To</th>
                        @endif                        
                        <th scope="col" class="py-3 px-6">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                <a href="{{ route('tasks.show', $task) }}" class="text-blue-600 hover:underline">{{ $task->title }}</a>
                            </td>
                            <td class="py-4 px-6">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : 'N/A' }}</td>
                            @if(Auth::user()->role === 'admin')
                                <td class="py-4 px-6">{{ $task->assignedUser->name ?? 'Unassigned' }}</td>
                            @endif    
                            <td class="py-4 px-6 flex space-x-2">
                                @can('update', $task)
                                    <a href="{{ route('tasks.edit', $task) }}" class="text-yellow-500 hover:text-yellow-700">
                                        <!-- Edit Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232a3 3 0 014.536 4.536l-9.5 9.5a1.5 1.5 0 01-.788.409l-3.5.5a.75.75 0 01-.883-.883l.5-3.5a1.5 1.5 0 01.409-.788l9.5-9.5zM13.5 6.5L17.5 10.5" />
                                        </svg>
                                    </a>
                                @endcan
                                {{-- @can('delete', $task) --}}
                                @if(Auth::user()->can('update', $task))
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <!-- Delete Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                {{-- @endcan --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
