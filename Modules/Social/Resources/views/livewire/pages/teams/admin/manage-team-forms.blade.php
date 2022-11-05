<div wire:init="onLoad">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">{{ Trans::get('Forms') }}</h1>
                <p class="mt-2 text-sm text-gray-700">{{ Trans::get('These are forms that will be sent to members of your Team. You can choose which date these forms are sent out.') }}</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <a 
                    href="{{ route('social.teams.forms.create', $team) }}"
                    class="inline-flex items-center justify-center rounded-md border border-transparent bg-black px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 sm:w-auto" 
                >Create a form</a>
            </div>
        </div>
        <div class="-mx-4 mt-8 overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                        <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell">Submissions</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">Active</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    <tr class="border-t border-gray-200">
                        <th colspan="4" scope="colgroup" class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6">{{ \Trans::get('Team Forms') }}</th>
                    </tr>
                    @forelse($teamForms as $form)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $form->name }}</td>
                            <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-gray-500 sm:table-cell">45</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 lg:table-cell">
                                <x-library::input.toggle />
                            </td>
                            <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                <a href="#" class="text-gray-600 hover:text-gray-900">Edit<span class="sr-only">, {{ $form->name }}</span></a>
                                <a href="#" class="text-danger-600 hover:text-danger-900">Delete<span class="sr-only">, {{ $form->name }}</span></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                <span wire:loading.remove>{{ \Trans::get('No Team Forms') }}</span>
                                <span wire:loading>{{ \Trans::get('Loading Forms...') }}</span>
                            </td>
                        </tr>
                        @endforelse
                    
                    <tr class="border-t border-gray-200">
                        <th colspan="4" scope="colgroup" class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-gray-900 sm:px-6">{{ \Trans::get('Platfrom Forms') }}</th>
                    </tr>
                    @forelse($platformForms as $form)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $form->name }}</td>
                            <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-gray-500 sm:table-cell">45</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 lg:table-cell">
                                <x-library::input.toggle />
                            </td>
                            <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit<span class="sr-only">, {{ $form->name }}</span></a>
                                <a href="#" class="text-danger-600 hover:text-danger-900">Delete<span class="sr-only">, {{ $form->name }}</span></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                <span wire:loading.remove>{{ \Trans::get('No Platform Forms') }}</span>
                                <span wire:loading>{{ \Trans::get('Loading Forms...') }}</span>
                            </td>
                        </tr>
                    @endforelse
        
                </tbody>
            </table>
        </div>
    </div>
</div>
