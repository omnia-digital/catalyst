<x-action-section>
    <x-slot name="title">
        {{ __('Delete Organization') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Permanently delete this organization.') }}
    </x-slot>

    <x-slot name="content">
        @if (($team->subscribed() && !$team->subscription()->onGracePeriod()) || $team->hasUnpaidExtraInvoiceItems() || $team->livestreamAccount->hasEpisodes())
            <p class="text-red-500 text-sm font-semibold">
                You cannot delete this team unless you <a href="/billing" class="underline hover:text-red-400">cancel
                    the current plan</a>, <a href="{{ route('settings.episode') }}"
                                             class="underline hover:text-red-400">delete all episodes</a>, and pay off
                all the open invoices.
            </p>
        @else
            <div class="max-w-xl text-sm text-gray-600">
                {{ __('Once a organization is deleted, all of its resources and data will be permanently deleted. Before deleting this organization, please download any data or information regarding this organization that you wish to retain.') }}
            </div>

            <div class="mt-5">
                <x-danger-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                    {{ __('Delete Organization') }}
                </x-danger-button>
            </div>

            <!-- Delete Team Confirmation Modal -->
            <x-confirmation-modal wire:model.live="confirmingTeamDeletion">
                <x-slot name="title">
                    {{ __('Delete Organization') }}
                </x-slot>

                <x-slot name="content">
                    <p>{{ __('Are you sure you want to delete this organization? Once a organization is deleted, all of its resources and data will be permanently deleted.') }}</p>
                    <p class="mt-3">{{ __('These resources include All Streams, Episodes, Templates, Images, Stream Targets, Channels, and Players. It will NOT delete the Users associated with the account.') }}</p>
                </x-slot>

                <x-slot name="footer">
                    <x-secondary-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-danger-button class="ml-2" wire:click="deleteTeam" wire:loading.attr="disabled">
                        {{ __('Delete Organization') }}
                    </x-danger-button>
                </x-slot>
            </x-confirmation-modal>
        @endif
    </x-slot>
</x-action-section>
