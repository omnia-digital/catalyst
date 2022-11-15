<div wire:init="onLoad">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">{{ Trans::get('Forms') }}</h1>
                <p class="mt-2 text-sm text-gray-700">{{ Trans::get('These are forms that will be sent to members of your Team. You can choose which date these forms are sent out.') }}</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <a 
                    href="{{ route('social.teams.admin.forms.create', $team) }}"
                    class="inline-flex items-center justify-center rounded-md border border-transparent bg-black px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-dark-text-color focus:ring-offset-2 sm:w-auto" 
                >Create a form</a>
            </div>
        </div>
        <div class="-mx-4 mt-8 overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-black sm:pl-6">Name</th>
                        <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-black lg:table-cell">Type</th>
                        <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-black lg:table-cell">Submissions</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    <tr class="border-t border-gray-200">
                        <th colspan="4" scope="colgroup" class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-black sm:px-6">{{ \Trans::get('Team Forms') }}</th>
                    </tr>
                    @forelse($teamForms as $form)
                        <tr>
                            <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-black sm:w-auto sm:max-w-none sm:pl-6">
                                {{ $form->name }} @if (!$form->isActive)<span class="italic text-light-text-color">(Draft)</span>@endif
                                <dl class="font-normal lg:hidden">
                                    <dt class="sr-only">Type</dt>
                                    <dd class="mt-1 truncate text-dark-text-color">{{ $form->formType?->name ?? '' }}</dd>
                                    <dt class="sr-only sm:hidden">Submissions</dt>
                                    <dd class="mt-1 truncate text-light-text-color">
                                        <a 
                                            href="{{ route('social.teams.forms.submissions', ['team' => $team, 'form' => $form]) }}"
                                            class="underline hover:no-underline focus:ring-1"
                                        >{{ $form->submissions()->count() }} {{ Str::plural('submission', $form->submissions()->count()) }}</a>
                                    </dd>
                                </dl>
                            </td>
                            <td class="hidden px-3 py-4 text-sm text-dark-text-color lg:table-cell">{{ $form->formType?->name ?? '' }}</td>
                            <td class="hidden px-3 py-4 text-sm text-light-text-color lg:table-cell">
                                <a 
                                    href="{{ route('social.teams.forms.submissions', ['team' => $team, 'form' => $form]) }}"
                                    class="underline hover:no-underline focus:ring-1"
                                >{{ $form->submissions()->count() }}</a>
                            </td>
                            <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 space-x-2">
                                <x-library::dropdown dropdownClasses="z-10">
                                    <x-slot name="trigger">
                                        <button
                                            type="button"
                                            id="menu-{{ $form->id }}-button"
                                            class="pl-2 py-2 flex items-center text-gray-400 hover:text-gray-600"
                                        >
                                            <span class="sr-only">Open actions, {{ $form->name }}</span>
                                            <x-heroicon-s-dots-vertical class="h-5 w-5"/>
                                        </button>
                                    </x-slot>

                                    <x-library::dropdown.item
                                        wire:click.prevent="confirmPublishForm('{{ $form->id }}', '{{ $form->isActive ? 'Make Draft' : 'Publish' }}')"
                                    >{{ $form->isActive ? 'Make Draft' : 'Publish' }}</x-library::dropdown.item>

                                    <!-- Edit Form -->
                                    <a 
                                        href="{{ route('social.teams.forms.edit', ['team' => $team, 'form' => $form]) }}" 
                                        class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-100 disabled:text-base-text-color"
                                    >Edit<span class="sr-only">, {{ $form->name }}</span></a>

                                    <!-- Delete Form -->
                                    <x-library::dropdown.item
                                        wire:click.prevent="confirmFormRemoval('{{ $form->id }}')"
                                        class="text-danger-600 hover:text-danger-900"
                                    >Delete<span class="sr-only">, {{ $form->name }}</span></x-library::dropdown.item>
                                </x-library::dropdown>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-black sm:pl-6">
                                <span wire:loading.remove>{{ \Trans::get('No Team Forms') }}</span>
                                <span wire:loading>{{ \Trans::get('Loading Forms...') }}</span>
                            </td>
                        </tr>
                        @endforelse

                    <tr class="border-t border-gray-200">
                        <th colspan="4" scope="colgroup" class="bg-gray-50 px-4 py-2 text-left text-sm font-semibold text-black sm:px-6">{{ \Trans::get('Platform Forms') }}</th>
                    </tr>
                    @forelse($platformForms as $form)
                        <tr>
                            <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-black sm:w-auto sm:max-w-none sm:pl-6">
                                {{ $form->name }}
                                <dl class="font-normal lg:hidden">
                                    <dt class="sr-only">Type</dt>
                                    <dd class="mt-1 truncate text-dark-text-color">{{ $form->formType?->name ?? '' }}</dd>
                                    <dt class="sm:hidden">Submissions</dt>
                                    <dd class="mt-1 truncate text-light-text-color sm:hidden">{{ $form->submissions()->count() }}</dd>
                                </dl>
                            </td>
                            <td class="hidden px-3 py-4 text-sm text-dark-text-color lg:table-cell">{{ $form->formType?->name ?? '' }}</td>
                            <td class="hidden px-3 py-4 text-sm text-light-text-color lg:table-cell">{{ $form->submissions()->count() }}</td>
                            <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"></td>
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
    <!-- Publish/Draft Form Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingPublishform">
        <x-slot name="title">
            {{ \Trans::get('Change Form Status') }}
        </x-slot>

        <x-slot name="content">
            {{ \Trans::get("Are you sure you would like to {$newStatus} this form?") }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingPublishform')" wire:loading.attr="disabled">
                {{ \Trans::get('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="changeFormStatus" wire:loading.attr="disabled">
                {{ \Trans::get($newStatus) }}
            </x-jet-button>
        </x-slot>
    </x-jet-confirmation-modal>
    <!-- Remove Form Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingFormRemoval">
        <x-slot name="title">
            {{ \Trans::get('Delete Form') }}
        </x-slot>

        <x-slot name="content">
            {{ \Trans::get('Are you sure you would like to delete this form?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingFormRemoval')" wire:loading.attr="disabled">
                {{ \Trans::get('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="removeForm" wire:loading.attr="disabled">
                {{ \Trans::get('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
