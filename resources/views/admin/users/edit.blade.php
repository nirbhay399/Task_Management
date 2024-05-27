@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-4">Edit User</h1>
    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="max-w-md">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
            <select name="role" class="form-select mt-1 block w-full">
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="permissions" class="block text-sm font-medium text-gray-700">Permissions</label>
            <select name="permissions[]" class="form-multiselect mt-1 block w-full" multiple>
                <option value="create-task" {{ in_array('create-task', json_decode($user->permissions ?? '[]', true)) ? 'selected' : '' }}>Create Task</option>
                <option value="assign-task" {{ in_array('assign-task', json_decode($user->permissions ?? '[]', true)) ? 'selected' : '' }}>Assign Task</option>
                <option value="assign-task" {{ in_array('View-task', json_decode($user->permissions ?? '[]', true)) ? 'selected' : '' }}>View Task</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Save</button>
    </form>
</div>
@endsection
