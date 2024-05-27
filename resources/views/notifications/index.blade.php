@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-4">Notifications</h1>

    @if ($notifications->isEmpty())
        <p class="text-gray-600">No notifications found.</p>
    @else
        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3 px-6">Notification</th>
                        <th scope="col" class="py-3 px-6">Date</th>
                        <th scope="col" class="py-3 px-6">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notifications as $notification)
                        <tr class="bg-white border-b hover:bg-gray-50 notification-row">
                            <td class="py-4 px-6">
                                {{ $notification->data['action'] }}: 
                                 <a href="{{ route('tasks.show', $notification->data['task_id']) }}" class="text-blue-600 hover:underline task-link">{{ $notification->data['task_title'] }}</a>                                 
                            </td>
                            <td class="py-4 px-6">
                                {{ $notification->created_at->diffForHumans() }}
                            </td>
                            <td class="py-4 px-6">
                                <a href="{{ route('notifications.markAsRead', $notification->id) }}" class="text-blue-600 hover:underline mark-as-read" data-notification-id="{{ $notification->id }}">Mark as read</a>
                            </td>
                        </tr>                       
                        
                    @endforeach
                </tbody>
            </table>
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection
