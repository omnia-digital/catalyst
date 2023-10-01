<div>
    <div class="mx-2 md:mx-0 bg-white p-4 xl:py-6 xl:px-10 rounded-lg shadow-xl text-xl md:mb-10">
        <form wire:submit.prevent="subscribe" class="md:flex items-center text-black mx-auto md:justify-between">
            <div class="w-full items-center text-center md:text-left md:pr-5">
                <p class="text-sm text-gray-400">Are you a contractor?</p>
                <p class="">Get instant emails of all new contracts</p>
                {{--                <div class="mr-5 mb-2 xl:mb-0">--}}
                {{--                    <x-input.select :options="$frequencies" wire:model="frequency"/>--}}
                {{--                </div>--}}
            </div>
            <div class="w-full mb-2 flex-grow xl:mb-0 items-center">
                <x-library::input.text wire:model="email" name="email" placeholder="Your Email"/>
                <x-library::input.error for="email"/>
            </div>
            <div class="items-center flex justify-end md:pl-4">
                <button class="bg-gradient-to-r from-red-700 via-red-600 to-red-500 rounded-lg shadow px-4 py-1 text-white hover:shadow-lg w-full xl:w-40 hover:bg-red-500
            font-medium transition duration-200 focus:outline-none">Subscribe
                </button>
            </div>
        </form>
    </div>
</div>
