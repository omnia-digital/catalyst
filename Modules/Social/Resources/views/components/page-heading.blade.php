<div class="w-full mb-4">
    <div class="relative shadow-xl sm:rounded-b-2xl sm:overflow-hidden">
        <div class="absolute inset-0 grayscale">
            <img class="h-full w-full object-cover"
                 src="https://images.unsplash.com/photo-1521737852567-6949f3f9f2b5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=2830&q=80&sat=-100"
                 alt="People working on laptops">
            <div class="absolute inset-0 bg-indigo-700 mix-blend-multiply"></div>
        </div>
        <div class="relative px-4 py-16 sm:px-6 sm:py-16 lg:py-16 lg:px-8">
            <x-library::heading.1 class="text-center text-3xl font-extrabold tracking-tight sm:text-4xl lg:text-5xl">
                <span class="block text-white uppercase">{{ $title }}</span>
            </x-library::heading.1>
            <p class="mt-6 max-w-lg mx-auto text-center text-xl text-indigo-200 sm:max-w-3xl">{{ $slot }}</p>
        </div>
    </div>
</div>