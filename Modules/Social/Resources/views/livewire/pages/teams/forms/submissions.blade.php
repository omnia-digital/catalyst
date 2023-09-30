@extends('social::livewire.layouts.pages.full-page-layout')

@section('content')
    <x-social::page-heading>
        <x-slot name="title">{{ Trans::get('Form Submissions') }}</x-slot>
        {{ $form->name }}
    </x-social::page-heading>

    <div x-data="{
    viewSubmission(submissionId) {
        this.$wire.updateCurrentSelected(submissionId)
        this.$openModal('team-submission-modal')
    }
}">
        <div class="space-y-6 p-4">
            <div class="text-right">
                <a class="hover:underline focus:ring-1"
                   href="{{ route('social.teams.admin', $team) }}">{{ Trans::get('Return to Team Admin Page') }}</a>
            </div>
            @forelse ($form->submissions as $submission)
                <div class="flex items-center justify-between">
                    <div class="text-base-text-color">{{ $submission->user->name }} ({{ $submission->user->email }})
                    </div>

                    <div class="flex items-center">
                        <button type="button"
                                class="inline-flex items-center px-4 py-2 rounded-full bg-white text-base-text-color text-sm tracking-wide font-medium border border-black hover:bg-neutral-light"
                                x-on:click.prevent="viewSubmission({{ $submission->id }})"
                        >View Submission
                        </button>
                    </div>
                </div>
            @empty
                <div>
                    <p>No submissions</p>
                </div>
            @endforelse
        </div>
        <x-library::modal id="team-submission-modal" maxWidth="3xl" hideCancelButton>
            <x-slot name="title">Submission: <span wire:loading.remove
                                                   wire:target="updateCurrentSelected">{{ $selectedSubmission->user->name }}</span>
            </x-slot>

            <x-slot name="content">
                <div>
                    <table class="w-full divide-y divide-gray-300">
                        <thead>
                        <tr>
                            <th scope="col" class="py-3.5 pr-3 text-left text-sm font-semibold text-gray-900">Field</th>
                            <th scope="col"
                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 table-cell">Value
                            </th>
                        </tr>
                        </thead>
                        <tbody wire:loading.class="animate-pulse" wire:target="updateCurrentSelected"
                               class="divide-y divide-gray-200">
                        @foreach ($selectedSubmission->data as $field => $value)
                            <tr wire:loading.remove wire:target="updateCurrentSelected">
                                <td class="w-full max-w-0 py-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none">
                                    {{ $value['label'] ?? $field }}
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-500 table-cell">{{ $value['data'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div wire:loading wire:target="updateCurrentSelected"
                         class="flex justify-center items-center gap-2">
                        <div class="h-2 w-full bg-neutral-dark rounded"></div>
                        <div class="h-2 w-full bg-neutral-dark rounded"></div>
                    </div>
                    @if ($selectedSubmission->teamApplication)
                        <div class="flex items-center mt-8 justify-end">
                            <button type="button"
                                    class="inline-flex items-center px-4 py-2 rounded-full bg-white text-base-text-color text-sm tracking-wide font-medium border border-black hover:bg-neutral-light"
                                    wire:click.prevent="addTeamMemberUsingID({{ $selectedSubmission->user->id }})"
                            >{{ Trans::get('Accept') }}</button>
                            @if (Gate::check('removeTeamMember', $team))
                                <!-- Deny Team Application -->
                                <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none"
                                        wire:click="denyTeamApplication({{ $selectedSubmission->teamApplication->id }})">
                                    {{ Trans::get('Deny') }}
                                </button>
                            @endif
                        </div>
                    @endif
                </div>
            </x-slot>
        </x-library::modal>
    </div>
@endsection
