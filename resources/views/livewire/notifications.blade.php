@extends('social::livewire.layouts.pages.default-page-layout')

@section('content')
    <div class="sticky top-[55px] z-40 mb-4 rounded-b-lg pl-4 flex items-center bg-secondary items-center">
        <div class="flex-1 flex items-center">
            <x-library::heading.1 class="py-4">Notifications</x-library::heading.1>
            @if(Auth::user()->notifications()->whereNull('read_at')->count() > 0 )
                <span class="ml-2 w-6 h-6 text-md flex items-center justify-center text-white-text-color bg-danger-600 rounded-full">
                            {{ Auth::user()->notifications()->whereNull('read_at')->count() }}
                        </span>
            @endif
        </div>
    </div>
    <div>
        <div class="border-b border-gray-200">
            <div class="sm:flex sm:items-baseline items-center">
                <div class="mt-4 sm:mt-0 sm:ml-10 md:ml-4">
                    <nav class="-mb-px flex space-x-8">
                        <a href="#" class="border-indigo-500 text-indigo-600 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm" aria-current="page"> {{ \Trans::get('All') }} </a>

                        <a href="#"
                           class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm"> {{ \Trans::get('Mentions') }} </a>
                    </nav>
                </div>
            </div>
        </div>

        <div>
            <div class="flow-root mt-6">
                <ul role="list" class="-my-5 divide-y divide-gray-200">
                    @foreach($notifications as $notification)
                        <x-notifications.item
                                :id="$notification->id"
                                :title="$notification->data['title']"
                                :subtitle="$notification->data['subtitle'] ?? null"
                                :level="$notification->data['level'] ?? 'info'"
                                :image="$notification->data['image'] ?? null"
                                :icon="$notification->data['icon'] ?? 'heroicon-o-information-circle'"
                                :action-link="$notification->data['action_link'] ?? null"
                                :action-text="$notification->data['action_text'] ?? 'View'"
                                :is-read="!is_null($notification->read_at)"
                        />
                    @endforeach
                </ul>
            </div>

            @if ($notifications->count() < $allNotificationCount)
                <div class="mt-6">
                    <a wire:click.prevent="loadMore" href="#"
                       class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        {{ \Trans::get('Load More') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
