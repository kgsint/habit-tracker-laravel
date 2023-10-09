@props(['completed' => false, 'body' => '', 'disabled' => false])

<input
    type="text"
    class="w-full outline-none border-transparent border-b border-b-gray-200 focus-visible:border-b-2 focus-visible:border-blue-50
    dark:text-white dark:bg-black {{ $completed ? 'line-through text-gray-500' : '' }}"
    value="{{ $body }}"
    {!! $attributes !!}
    {{ $disabled ? 'disabled' : '' }}
>
