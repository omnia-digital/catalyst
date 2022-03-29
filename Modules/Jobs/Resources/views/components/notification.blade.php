<div class="fixed inset-x-0 bottom-0 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end z-50">
    <div
        x-data="{ show: false, message: '', type: '', action: '' }"
        x-on:notify.window="type = $event.detail.type; show = true; action = $event.detail.action; message = $event.detail.message; setTimeout(() => { show = false }, 3000)"
        x-show="show"
        x-description="Notification panel, show/hide based on alert state."
        x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="max-w-sm w-full shadow-lg rounded-lg pointer-events-auto"
        :class="{'bg-green-400': type === 'success', 'bg-red-400': type === 'error'}"
        style="display: none"
    >
        <div class="rounded-lg shadow-xs overflow-hidden">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p x-text="message" class="text-sm leading-5 font-medium text-white"></p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button @click="show = false" class="inline-flex text-white focus:outline-none focus:text-base-text-color transition ease-in-out duration-150">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <a x-show="action" :href="action" class="text-center block bg-primary text-base-text-color rounded p-2 mt-2 w-full font-medium hover:text-dark-text-color">Buy More Credits</a>
            </div>
        </div>
    </div>
</div>
