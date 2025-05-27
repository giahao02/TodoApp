<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Todo List with Tailwind and Alpinejs</title>
    {{-- @vite('resources/js/app.js') --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <script defer type="module" src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.14.8/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script> --}}


</head>

<body class=" bg-gray-100" x-data="todoApp">
    @include('layouts.navigation')
    <header>
        <h1 class="flex item-center justify-center p-5 text-4xl font-bold">Todo List with Tailwind, Alpinejs and Laravel
        </h1>
    </header>
    <div x-show="notification.show" x-text="notification.message"
        :class="{
            'bg-green-500 text-white': notification.type === 'success',
            'bg-red-500 text-white': notification.type === 'error'
        }"
        class="fixed top-4 left-1/2 transform -translate-x-1/2 px-4 py-4 rounded z-50" x-transition></div>
    <main class="max-w-3xl mx-auto rounded-xl pt-5 px-5 pb-28">
        <section class="space-y-4">
            <div class="flex gap-3">
                <h2 class="font-bold" x-text="'To Dos: ' + state.total"></h2>
                <span>|</span>
                <h2 class="font-bold" x-text="'Completed: ' + state.completed"></h2>
            </div>
            <div class="flex justify-between mb-6 bg-red-50">
                <h2 class="font-bold"
                    x-text="state.completed === state.total ? 'Congrats you finished your list!' : (state.total - state.completed) + ' more to go!'">
                </h2>
                <select x-model="state.filter" class="bg-white border rounded-md max-w-fit max-h-fit">
                    <option value="all" selected="selected">All</option>
                    <option value="completed">Completed</option>
                    <option value="uncompleted">Uncompleted</option>
                </select>
            </div>
        </section>

        <section>
            <template x-for="(item, index) in filterTask()" :key="item.id">
                <div class="group flex items-start justify-between gap-x-4 rounded-md mb-3 p-3 border border-gray-300"
                    x-bind:class="item.is_completed == 1 ? 'bg-gray-300' : 'bg-gray-100'">
                    <div class="shrink-0 cursor-pointer group">
                        <input :id="'checkbox-' + index" type="checkbox" class="hidden peer"
                            :checked="item.is_completed" x-on:change="toggleComplete(item.id, item.is_completed)" />
                        <span :for="'checkbox-' + index" x-on:click.prevent="$el.previousElementSibling.click()"
                            class="mt-1 rounded-sm bg-gray-300 w-5 h-5 inline-flex items-center justify-center
             transform transition-all duration-200 ease-in-out
             group-hover:scale-110">
                            <svg x-show="item.is_completed == 0 ? false : true" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="1.2">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M20.6097 5.20743C21.0475 5.54416 21.1294 6.17201 20.7926 6.60976L10.7926 19.6098C10.6172 19.8378 10.352 19.9793 10.0648 19.9979C9.77765 20.0166 9.49637 19.9106 9.29289 19.7072L4.29289 14.7072C3.90237 14.3166 3.90237 13.6835 4.29289 13.2929C4.68342 12.9024 5.31658 12.9024 5.70711 13.2929L9.90178 17.4876L19.2074 5.39034C19.5441 4.95258 20.172 4.87069 20.6097 5.20743Z"
                                        fill="#000000"></path>
                                </g>
                            </svg> </span>
                    </div>
                    <div class="grow min-w-0">
                        <label :for="'checkbox-' + index"
                            class="block cursor-pointer break-words whitespace-normal select-none"
                            x-text="item.description"></label>
                    </div>
                    <div class="shrink-0 -mt-3 mr-1">
                        <button x-on:click="removeTask(item.id)" class="text-gray-500 text-xs hover:text-red-500">
                            Remove
                        </button>
                    </div>
                </div>
            </template>
        </section>
    </main>
    <section class="fixed bottom-0 left-0 right-0 px-4 py-3">
        <div class="max-w-3xl mx-auto flex items-center gap-2 px-5 py-5 bg-white rounded-xl">
            <input class="grow min-w-0 p-2 outline-none focus:border focus:border-black" type="text"
                x-model="newTodo" placeholder="Add todo item" @keydown.enter="addTask" />
            <button
                class="shrink-0 p-2 transform transition-all duration-200 ease-in-out
             hover:scale-110 hover:bg-gray-100 active:bg-gray-200"
                x-on:click="addTask">
                <svg class="h-4 sm:h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512">
                    <path
                        d="M 256 48 Q 313 48 360 76 L 360 76 L 360 76 Q 407 103 436 152 Q 464 201 464 256 Q 464 311 436 360 Q 407 409 360 436 Q 313 464 256 464 Q 199 464 152 436 Q 105 409 76 360 Q 48 311 48 256 Q 48 201 76 152 Q 105 103 152 76 Q 199 48 256 48 L 256 48 Z M 256 512 Q 326 511 384 478 L 384 478 L 384 478 Q 442 444 478 384 Q 512 323 512 256 Q 512 189 478 128 Q 442 68 384 34 Q 326 1 256 0 Q 186 1 128 34 Q 70 68 34 128 Q 0 189 0 256 Q 0 323 34 384 Q 70 444 128 478 Q 186 511 256 512 L 256 512 Z M 232 344 Q 234 366 256 368 Q 278 366 280 344 L 280 280 L 280 280 L 344 280 L 344 280 Q 366 278 368 256 Q 366 234 344 232 L 280 232 L 280 232 L 280 168 L 280 168 Q 278 146 256 144 Q 234 146 232 168 L 232 232 L 232 232 L 168 232 L 168 232 Q 146 234 144 256 Q 146 278 168 280 L 232 280 L 232 280 L 232 344 L 232 344 Z" />
                </svg>
            </button>
        </div>
    </section>
</body>

</html>
