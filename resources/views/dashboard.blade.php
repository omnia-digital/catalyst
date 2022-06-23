<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-color-dark leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-primary overflow-hidden shadow-xl sm:rounded-lg min-h-screen p-8">
                <h3 class="py-4 text-xl font-bold">Modal</h3>

                <button x-data x-on:click.prevent.stop="$openModal('test-modal')" type="button" class="border border-secondary px-4 py-2">
                    Open Modal
                </button>

                <x-library::modal id="test-modal">
                    <x-slot name="title">A</x-slot>
                    <x-slot name="content">A</x-slot>
                </x-library::modal>

                <h3 class="py-4 text-xl font-bold">Accordion</h3>

                <x-library::accordion default="1">
                    <x-library::accordion.item id="1">
                        <x-slot name="title">Question 1</x-slot>
                        <x-slot name="content">Answer 1</x-slot>
                    </x-library::accordion.item>

                    <x-library::accordion.item id="2">
                        <x-slot name="title">Question 2</x-slot>
                        <x-slot name="content">Answer 2</x-slot>
                    </x-library::accordion.item>
                </x-library::accordion>

                <h3 class="py-4 text-xl font-bold">Dropdown</h3>

                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                    <button type="button" class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-primary text-sm font-medium text-color-dark hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary">Save changes</button>
                    <x-library::dropdown>
                        <x-slot name="trigger">
                            <span class="-ml-px relative block">
                                <button type="button" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-primary text-sm font-medium base-text-color hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary" id="option-menu-button" aria-expanded="true" aria-haspopup="true">
                                    <span class="sr-only">Open options</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </span>
                        </x-slot>

                        <x-library::dropdown.group>
                            <x-library::dropdown.item>Dropdown 1</x-library::dropdown.item>
                            <x-library::dropdown.item>Dropdown 2</x-library::dropdown.item>
                        </x-library::dropdown.group>

                        <x-library::dropdown.group>
                            <x-library::dropdown.item>Dropdown 3</x-library::dropdown.item>
                            <x-library::dropdown.item>Dropdown 4</x-library::dropdown.item>
                        </x-library::dropdown.group>
                    </x-library::dropdown>
                </span>


                <h3 class="py-4 text-xl font-bold">Notification</h3>

                <x-library::notification/>

                <form
                    x-data="{
                        content: 'Something happened!',
                        type: 'info',
                    }"
                    class="max-w-lg"
                    x-on:submit.prevent="$dispatch('notify', { content, type })"
                >
                    <div>
                        <label for="message" class="text-sm font-bold">
                            Message
                        </label>

                        <input id="message" x-model="content" type="text" class="mt-1 block w-full border border-secondary rounded px-3 py-2">
                    </div>

                    <div class="mt-4">
                        <label for="type" class="text-sm font-bold">
                            Type
                        </label>

                        <select id="type" x-model="type" type="text" class="mt-1 block w-full border border-secondary rounded px-3 py-2">
                            <option value="info">Info</option>
                            <option value="success">Success</option>
                            <option value="error">Error</option>
                        </select>
                    </div>

                    <button class="mt-6 inline-flex border border-secondary rounded shadow px-4 py-2">
                        Dispatch notification
                    </button>
                </form>

                <h3 class="py-4 text-xl font-bold">Tabs</h3>

                <x-library::tab default="2">
                    <x-slot name="items">
                        <x-library::tab.item>Tab 1</x-library::tab.item>
                        <x-library::tab.item>Tab 2</x-library::tab.item>
                    </x-slot>

                    <x-slot name="panels">
                        <x-library::tab.panel>Content of tab 1</x-library::tab.panel>
                        <x-library::tab.panel>Content of tab 2</x-library::tab.panel>
                    </x-slot>
                </x-library::tab>

                <h3 class="py-4 text-xl font-bold">Tooltip</h3>

                <div class="flex items-center justify-center gap-2">
                    <button
                        x-data
                        x-tooltip="I am a tooltip!"
                        type="button"
                        class="border border-secondary rounded shadow px-4 py-2"
                    >
                        Hover over me
                    </button>

                    <button
                        x-data
                        @click="$tooltip('I am a tooltip!')"
                        type="button"
                        class="border border-secondary rounded shadow px-4 py-2"
                    >
                        Click me
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
