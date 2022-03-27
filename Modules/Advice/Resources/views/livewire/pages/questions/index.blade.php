@extends('advice::livewire.layouts.main-layout')

@section('content')
    <div class="xl:grid xl:grid-cols-9 xl:gap-9">
        <div class="xl:col-span-6">
            <div class="mb-2 flex justify-between items-center">
                <div class="flex-1 flex items-center">
                    <h1 class="py-2 text-3xl">Questions</h1>
                </div>

                <x-library::button x-data="" class="py-2 w-60 h-10" x-on:click.prevent="$openModal('add-resource-modal')">
                    Ask a New Question
                </x-library::button>
                <livewire:advice::pages.questions.create/>
            </div>

            <!-- Filters -->
            @include('livewire.partials.filters')

            <div class="">
                <ul role="list" class="space-y-4">
                    @foreach($questions as $question)
                        <li>
                            <livewire:social::post-list-item :post="$question" :wire:key="$question->id" />
                        </li>
                    @endforeach
                </ul>

                <div class="pb-6">
                    {{ $questions->onEachSide(1)->links() }}
                </div>
            </div>
        </div>

        <aside class="hidden xl:block xl:col-span-3">
            <div class="sticky h-screen overflow-y-scroll scrollbar-hide top-4 space-y-4 pb-36 bg-white shadow rounded-lg">
                <livewire:social::partials.trending-section title="Top questions" type="resource"/>
                <livewire:social::partials.who-to-follow-section/>
                <livewire:social::partials.applications/>
            </div>
        </aside>
    </div>
@endsection
@push('scripts')
    <script>
        function setup() {
            return {
                activeTab: 0,
                tabs: [
                    {
                        id: 0,
                        title: 'My Feed',
                        component: 'social.posts'
                    },
                    {
                        id: 1,
                        title: 'Top Projects',
                        component: 'social.top-projects'
                    },
                    {
                        id: 2,
                        title: 'Newest',
                        component: 'social.newest'
                    },
                    {
                        id: 3,
                        title: 'Favorites',
                        component: 'social.favorites'
                    },
                    {
                        id: 4,
                        title: 'Undiscovered',
                        component: 'social.undiscovered'
                    },
                ],
                notifications: '<span class="ml-2 text-xs w-5 h-5 flex items-center justify-center text-white bg-black rounded-full">3</span>',
            }
        }
    </script>
@endpush