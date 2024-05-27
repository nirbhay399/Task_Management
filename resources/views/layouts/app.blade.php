<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>                    
                </header>
            @endif
            
            <!-- Page Content -->
            <main>
                @if (Route::currentRouteName() === 'profile.edit')
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </main>
        </div>
        
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const notificationDropdownButton = document.getElementById('notificationDropdownButton');
            const notificationDropdown = document.getElementById('notificationDropdown');
            const notificationCount = document.getElementById('notificationCount');
            const notificationList = document.getElementById('notificationList');

            // Toggle dropdown visibility
            notificationDropdownButton.addEventListener('click', function () {
                notificationDropdown.classList.toggle('hidden');
                loadNotifications();
            });

            function loadNotifications() {
                fetch('/notifications/unread')
                    .then(response => response.json())
                    .then(data => {
                        notificationList.innerHTML = '';
                        if (data.notifications.length === 0) {
                            notificationList.innerHTML = '<p class="px-4 py-2 text-sm text-gray-600">No new notifications.</p>';
                            notificationCount.classList.add('hidden');
                        } else {
                            data.notifications.forEach(notification => {
                                const notificationItem = document.createElement('div');
                                notificationItem.classList.add('px-4', 'py-2', 'text-sm', 'text-gray-700', 'hover:bg-gray-100');
                                notificationItem.innerHTML = ` 
                                    ${notification.data.action}: ${notification.data.task_title}
                                    <br>
                                    <small>${new Date(notification.created_at).toLocaleString()}</small>
                                `;

                                notificationItem.addEventListener('click', () => {
                                    markAsRead(notification.id, notificationItem);
                                    window.open(`/tasks/${notification.data.task_id}`, '_blank');
                                    // Decrease the count
                                    notificationCount.textContent = parseInt(notificationCount.textContent) - 1;
                                });

                                notificationList.appendChild(notificationItem);
                            });
                            notificationCount.classList.remove('hidden');
                            notificationCount.innerText = data.unread_count;
                        }
                    });
            }

            // Mark notification as read and remove it
            function markAsRead(notificationId, notificationItem) {
                fetch(`/notifications/mark-as-read/${notificationId}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        notificationItem.remove();
                    } else {
                        console.error('Failed to mark notification as read:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }

            // Initial load to set the notification count
            fetch('/notifications/unread-count')
                .then(response => response.json())
                .then(data => {
                    if (data.unread_count === 0) {
                        notificationCount.classList.add('hidden');
                    } else {
                        notificationCount.classList.remove('hidden');
                        notificationCount.innerText = data.unread_count;
                    }
                });
        });
    </script>

    </body>
</html>
