<x-app-layout>
    <header class="shadow">
        <div class="flex justify-between mb-3 bg-gray-100 dark:bg-gray-800 p-3 rounded-lg">
            <h5 class="text-gray-500 dark:text-gray-400">
                Planned
            </h5>
            <a
                href="{{ route('habits.create') }}"
                class="px-2 py-1 bg-blue-400 text-white rounded-md ease hover:opacity-100 opacity-80 duration-300 dark:opacity-100"
            >
                Track a new habit
            </a>
        </div>
    </header>
        {{-- flash message --}}
        {{-- @if (session('status'))
            <div id="flash-message" class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                {{ session('status') }}
          </div>
        @endif --}}

    <div class="flex items-center flex-wrap gap-4">
        @forelse ($habits as $habit)
            <div class="card md:w-[300px] md:h-52 relative">
                    <h3 class="text-xl -ml-3 border-l-[4px] pl-3 border-l-blue-400 font-semibold pb-4">
                            <a href="{{ route('habits.show', $habit->id) }}" class="hover:underline duration-150">{{ $habit->title }}</a>
                    </h3>
                <div class="text-sm text-gray-600 leading-7 dark:text-gray-400">
                    {{ Str::limit($habit->description) }}
                </div>

                <div class="block text-right absolute bottom-2 right-2">
                    <button
                        class="text-sm text-red-500 p-3"
                        id="delete-btn"
                        data-habit="{{ json_encode($habit->only(['id', 'title'])) }}"
                    >
                        Delete
                    </button>
                </div>
            </div>
        @empty
            <div class="mx-auto text-gray-600">There is no habit to track at the moment. Please
                <a href="{{ route('habits.create') }}" class="text-blue-500 hover:underline">create one</a>
            </div>
        @endforelse
    </div>

    @vite(['resources/js/habit-delete.js'])
</x-app-layout>
