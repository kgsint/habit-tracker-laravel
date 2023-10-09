@props(['completed'])


<input type="checkbox"
    {!! $attributes->merge(['class' => 'cursor-pointer my-auto focus:ring-2 focus:ring-blue-100 w-5 h-5']) !!} {{ $completed ? 'checked' : '' }}
    id="task-checkbox"
>
