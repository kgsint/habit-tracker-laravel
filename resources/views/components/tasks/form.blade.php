@props(['habit', 'task'])

<form
    id="taskUpdateForm"
    action="{{ route('tasks.update', ['habit' => $habit->id, 'task' => $task->id]) }}"
    method="POST"
>
    @csrf
    <div class="flex justify-between space-x-1">
        <x-tasks.input
            name="body"
            :completed="$task->is_complete"
            :body="$task->body"
            {{-- :disabled="$task->is_complete" --}}
        />
        <x-tasks.checkbox
            name="is_complete"
            :completed="$task->is_complete"
        />
    </div>
</form>
