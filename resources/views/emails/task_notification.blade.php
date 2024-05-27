@component('mail::message')
# Hello!

A task has been {{ $action }}.

@component('mail::button', ['url' => url('/tasks/' . $task->id)])
View Task
@endcomponent

Thank you for using our application!

Regards,<br>
{{ config('app.name') }}

@slot('subcopy')
If you're having trouble clicking the "View Task" button, copy and paste the URL below into your web browser: [{{ url('/tasks/' . $task->id) }}]({{ url('/tasks/' . $task->id) }})
@endslot
@endcomponent
