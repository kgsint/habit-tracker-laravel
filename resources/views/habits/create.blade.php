<x-app-layout>
    <div class="p-3 max-w-3xl mx-auto">
        <form action="{{ route('habits.store') }}" method="POST" class="bg-white dark:bg-black shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <h2 class="text-gray-600 mb-6 pb-2 text-xl border-b border-blue-400">Create a new habit and Track the progress</h2>

            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-400 text-sm font-bold mb-2 sr-only" for="title">
                Title for your habit
                </label>
                <input
                        class="shadow appearance-none border
                        focus:border-blue-400 duration-200
                        rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline
                        dark:bg-black
                        dark:text-white
                        @error('title')
                        border-red-500
                        @enderror"
                        value="{{ old('title') }}"
                        id="title"
                        type="text"
                        name="title"
                        placeholder="e.g Read books every night, Walk 100m every morning, etc...">

                @error('title')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-400 text-sm font-bold mb-2 sr-only" for="description">
            Description
            </label>
            <textarea
                name="description"
                class="shadow appearance-none border
                dark:bg-black
                dark:text-white
                @error('description')
                border-red-500
                @enderror
                rounded w-full px-3 text-gray-700 leading-tight
                focus:outline-none py-2 focus:border focus:border-blue-400 duration-200 focus:shadow-outline" placeholder="Brief description why you to stick to this habit..." cols="30" rows="4"
                >{{old('description')}}</textarea>

            @error('description')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Create
            </button>

            <a
                href="{{ route('habits.index') }}"
                class="border border-gray-500 text-black dark:text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Cancel
            </a>

        </div>

        </form>
    </div>
</x-app-layout>
