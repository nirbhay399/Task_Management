@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-4">Notification Details</h1>
        <div class="bg-white shadow-md rounded-lg p-4">
            <p><strong>Action:</strong> {{ $notification->data['action'] }}</p>
            <p><strong>Task:</strong> {{ $notification->data['task_title'] }}</p>
            <p><strong>Date:</strong> {{ $notification->created_at->format('Y-m-d H:i:s') }}</p>
        </div>
    </div>
@endsection
