@extends('social::livewire.layouts.social-app')

@section('content')
    <div>
        <!-- Page Heading -->
        <div class="xl:grid xl:grid-cols-9 xl:gap-9">
            <div class="xl:col-span-6">
                {{--            <div>--}}
                {{--                <div class="sm:hidden">--}}
                {{--                    <label for="question-tabs" class="sr-only">Select a tab</label>--}}
                {{--                    <select id="question-tabs" class="block w-full rounded-md border-gray-300 text-base font-medium text-gray-900 shadow-sm focus:border-rose-500 focus:ring-rose-500">--}}
                {{--                        @foreach ($tabs as $tab)--}}
                {{--                            <option :selected="$tab['current']">{{ $tab['name'] }}</option>--}}
                {{--                        @endforeach--}}
                {{--                    </select>--}}
                {{--                </div>--}}
                {{--                <div class="hidden sm:block">--}}
                {{--                    <nav class="relative z-0 rounded-lg shadow flex divide-x divide-gray-200" aria-label="Tabs">--}}
                {{--                        @foreach($tabs as $tab)--}}
                {{--                            <x-sort-button key="created_at" :orderBy="$orderBy">--}}
                {{--                                {{ $tab['name'] }}--}}
                {{--                            </x-sort-button>--}}
                {{--                        @endforeach--}}
                {{--                    </nav>--}}
                {{--                </div>--}}
                {{--            </div>--}}

                <div class="">
                    <ul role="list" class="space-y-4">
                        @foreach ($activities as $activity)
                            @if($loop->index == 3)
                                <livewire:social::map/>
                            @endif
                            <livewire:social::partials.activity-list-item :activity="$activity"/>
                        @endforeach
                    </ul>
                </div>
                <div class="mt-4">
                    <livewire:social::new-post-box class="my-6" :user="auth()->user()"/>
                    <h1 class="sr-only">Recent Posts</h1>
                    <ul role="list" class="mt-6 space-y-4">
                        @foreach ($questions as $question)
                            <li>
                                <livewire:social::post-list-item :post="$question"/>
                            </li>
                        @endforeach
                        {{-- <li v-for="question in questions" :key="question.id">
                            <post-list-item :post="question"></post-list-item>
                        </li> --}}
                    </ul>
                </div>
            </div>
            <aside class="hidden xl:block xl:col-span-3">
                <div class="sticky top-4 space-y-4">
                    <livewire:social::partials.trending-section/>
                    <livewire:social::partials.who-to-follow-section/>
                </div>
            </aside>
        </div>
    </div>
@endsection
