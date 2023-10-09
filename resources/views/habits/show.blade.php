<x-app-layout>
    <header class="mt-3">
        <a
        href="/"
        class="inline-block px-2 py-3 text-xs bg-blue-500 text-white rounded-md mb-4 hover:bg-blue-400 duration-200"
        >
        Go back
        </a>

        <div class="flex justify-between mb-3 bg-gray-100 dark:bg-gray-800  p-3 rounded-lg">
            <h5 class="text-gray-500 dark:text-gray-300">
                <a href="{{ route('habits.index') }}" class="hover:underline">Home</a> / {{ $habit->title }}
            </h5>

            <div class="flex space-x-4 items-center">
                <a
                    href="{{ route('habits.edit', $habit->id) }}"
                    class="px-2 py-1 bg-blue-400 text-white rounded-md hover:bg-blue-400 hover:text-blue-700 duration-200"
                >
                    Edit
                </a>
            </div>
        </div>
    </header>


    <main>
        <div class="flex flex-col md:flex-row gap-4">
            <div class="md:w-3/4">

                {{-- TODO - implemet tasks --}}
                <div class="mb-6">
                    <h2 class="text-gray-600 mb-1">Tasks</h2>

                    {{-- add task --}}
                    <div class="card">
                        <form action="{{ route('tasks.store', $habit->id) }}" method="POST">
                            @csrf

                            <input
                            type="text"
                            placeholder="Click Enter to add a task to track"
                            name="body"
                            class="w-full focus-visible:border-b-2 outline-none focus-visible:border-blue-300 dark:text-white dark:bg-black"
                            autocomplete="off"
                            />
                        </form>
                    </div>

                </div>

            </div>

            <div class="md:w-1/2">
                <div class="card py-6 flex flex-col space-y-6">
                    <h3 class="text-xl font-semibold -ml-3 border-l-[4px] pl-3 border-l-blue-400">
                        {{ $habit->title }}
                    </h3>
                    <p class="text-sm leading-6 text-gray-400 flex-1">
                        {{ $habit->description }}
                    </p>

                        <button
                            class="text-red-500
                            text-sm
                            border border-red-400 p-2
                            hover:bg-red-500 hover:text-white rounded-md duration-200 ease-in-out"
                            id="delete-btn"
                            data-habit="{{ json_encode($habit->only(['id', 'title'])) }}"
                        >
                        Delete
                        </button>

                </div>

            </div>
        </div>
    </main>

    @vite(['resources/js/habit-delete.js'])
</x-app-layout>
