<x-jet-action-section>
    <x-slot name="title">
        {{ __('Delete Organization') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Permanently delete this organization.') }}
    </x-slot>

    <x-slot name="content">
        @if (($team->subscribed() && !$team->subscription()->onGracePeriod()) || $team->hasUnpaidExtraInvoiceItems() || $team->livestreamAccount->hasEpisodes())
            <p class="text-red-500 text-sm font-semibold">
                You cannot delete this team unless you <a href="/billing" class="underline hover:text-red-400">cancel the current plan</a>, <a href="{{ route('settings.episode') }}" class="underline hover:text-red-400">delete all episodes</a>, and pay off all the open invoices.
            </p>
        @else
            <div class="max-w-xl text-sm text-gray-600">
                {{ __('Once a organization is deleted, all of its resources and data will be permanently deleted. Before deleting this organization, please download any data or information regarding this organization that you wish to retain.') }}
            </div>

            <div class="mt-5">
                <x-jet-danger-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                    {{ __('Delete Organization') }}
                </x-jet-danger-button>
            </div>

            <!-- Delete Team Confirmation Modal -->
            <x-jet-confirmation-modal wire:model="confirmingTeamDeletion">
                <x-slot name="title">
                    {{ __('Delete Organization') }}
                </x-slot>

                <x-slot name="content">
                    <p>{{ __('Are you sure you want to delete this organization? Once a organization is deleted, all of its resources and data will be permanently deleted.') }}</p>
                    <p class="mt-3">{{ __('These resources include All Streams, Episodes, Templates, Images, Stream Targets, Channels, and Players. It will NOT delete the Users associated with the account.') }}</p>
                </x-slot>

                <x-slot name="footer">
                    <x-jet-secondary-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-jet-secondary-button>

                    <x-jet-danger-button class="ml-2" wire:click="deleteTeam" wire:loading.attr="disabled">
                        {{ __('Delete Organization') }}
                    </x-jet-danger-button>
                </x-slot>
            </x-jet-confirmation-modal>
        @endif
    </x-slot>
</x-jet-action-section>
