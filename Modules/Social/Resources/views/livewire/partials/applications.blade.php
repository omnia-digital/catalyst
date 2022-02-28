<div class="bg-white rounded-lg shadow">
    <div class="flex-1 p-6 space-y-1 overflow-y-auto">
        <h2 class="text-base font-bold">Applications</h2>
        <div x-data="applicationsSetup()">
            <ul class="flex justify-center items-center my-4">
                <template x-for="(tab, index) in tabs" :key="index">
                    <li class="flex flex-1 text-sm cursor-pointer py-2 px-6 text-gray-500 border-b-2 justify-center"
                        :class="activeTab===index ? 'text-black font-bold border-black' : ''" @click="activeTab = index"
                        x-html="tab + notifications"></li>
                </template>
            </ul>

            <div class="bg-white mx-auto">
                <div x-show="activeTab===0">
                    <div class="flex justify-between">
                        <div class="flex flex-col divide-y">
                            @foreach ($invitations as $invitation)
                                <div class="py-3">
                                    <div class="flex items-center">
                                        <div class="mr-3 w-12 h-12 rounded-full shadow">
                                            <img class="w-full h-full overflow-hidden object-cover object-center rounded-full" src="{{ $invitation['user']['avatar'] }}" alt="avatar" />
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="mb-2 sm:mb-1 text-gray-800 text-sm font-normal leading-5"><span class="font-bold">{{ $invitation['from'] }}</span> wants to join <div class="font-bold">{{ $invitation['subject'] }}</div></h3>
                                        </div>
                                    </div>
                                    <div class="py-3">
                                        <div class="flex justify-center divide-x mt-5">
                                            <span class="flex items-center text-md px-6 rounded-md font-semibold cursor-pointer">
                                                <x-heroicon-o-check class="w-6 h-6 mr-2" />
                                                Accept
                                            </span>
                                            <span class="flex items-center text-md px-6 rounded-md font-semibold cursor-pointer">
                                                <x-heroicon-o-x class="w-6 h-6 mr-2" />
                                                Decline
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div x-show="activeTab===1">Sent</div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    function applicationsSetup() {
        return {
            activeTab: 0,
            tabs: [
                'Received',
                'Sent',
            ],
            notifications: '<span class="ml-2 text-xs w-5 h-5 flex items-center justify-center text-white bg-black rounded-full">3</span>',
        }
    }
</script>
@endpush
