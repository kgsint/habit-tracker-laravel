@props(['habit', 'task'])

<form
    id="taskUpdateForm"
    action="{{ route('tasks.update', ['habit' => $habit->id, 'task' => $task->id]) }}"
    method="POST"
>
    @csrf
    @method('PATCH')

    <div class="flex justify-between space-x-1">
        <x-tasks.input
            name="body"
            :completed="$task->is_complete"
            :body="$task->body"
        />
        <x-tasks.checkbox
            name="is_complete"
            :completed="$task->is_complete"
        />
    </div>
</form>
