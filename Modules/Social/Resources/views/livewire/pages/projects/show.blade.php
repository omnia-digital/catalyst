@extends('social::livewire.layouts.main-layout')


@section('content')
<div class="-mx-4">
    <div class="h-60 bg-[url('https://source.unsplash.com/random')] bg-cover bg-no-repeat"></div>
    <livewire:social::components.project-navigation :project="$project" />
</div>
<div class="flex space-x-6 mt-4 -mx-4">
    <div class="space-y-4">
        <div class="lg:grid lg:grid-rows-1 lg:grid-cols-3 lg:gap-4">
            <div class="col-span-2 row-span-1 flex flex-col">
                <div class="flex-1 bg-[url('https://source.unsplash.com/random')] bg-cover bg-no-repeat"></div>
                <div class="flex w-full mt-2 space-x-1">
                    @foreach ([1, 2, 3, 4] as $num)
                        <img src="https://source.unsplash.com/random" alt="project-display-img-{{ $num }}" class="w-1/4 h-24">
                        
                    @endforeach
                </div>
            </div>
            <div class="col-span-1 row-span-1 flex flex-col">
                <div class="flex-1 bg-white rounded">
                    <div class="h-44 bg-[url('https://source.unsplash.com/random')] bg-cover bg-no-repeat"></div>
                    <div class="p-2 space-y-4">
                        <p class="text-sm">{{ $project->summary }}</p>
                        <div class="text-xs grid grid-cols-4 grid-rows-4 gap-1 items-center">
                            <span class="col-span-1 text-gray-400 text-xxs uppercase">Launch Date</span>
                            <div class="col-span-3 flex items-center space-x-2">
                                <x-heroicon-o-calendar class="w-4 h-4" />
                                <span>{{ \Carbon\Carbon::parse($project->start_date)->toFormattedDateString() }}</span>
                            </div>
                            <span class="col-span-1 text-gray-400 text-xxs uppercase">Location:</span>
                            <div class="col-span-3 flex items-center space-x-2">
                                <x-heroicon-o-location-marker class="w-4 h-4" />
                                <span>{{ $project->location ?? "Not Set"}}</span>
                            </div>
                            <span class="col-span-1 text-gray-400 text-xxs uppercase ">Organizer:</span>
                            <div class="col-span-3 flex items-center space-x-2">
                                <x-heroicon-s-user-circle class="w-4 h-4" />
                                <span>{{ $this->owner->name }}</span>
                            </div>
                            <span class="col-span-1 text-gray-400 text-xxs uppercase">Reviews:</span>
                            <div class="col-span-3 flex items-center space-x-2">
                                <div class="bg-black flex items-center rounded-md mr-1 p-1">
                                    <div class="flex items-center text-white text-xs font-semibold">
                                        <x-heroicon-s-star class="w-4 h-4" />
                                        {{ $project->reviewScore ?? '3758' }}
                                    </div>
                                </div>
                                <span class="text-gray-400 text-xxs">{{ $project->reviewStatus ?? 'Overwhelmingly Positive' }} ({{ /* $project->reviews()->count */'296,418' }})</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            @foreach ($additionalInfo as $item)
                                <div>
                                    <p class="text-light-text-color text-xxs">{{ $item }}</p>
                                    <p class="text-dark-text-color font-semibold text-lg">{{ $project->$item()->count() }}</p>
                                </div>
                            @endforeach
                            <div>
                                <p class="text-light-text-color text-xxs">views</p>
                                <p class="text-dark-text-color font-semibold text-lg">843</p>
                            </div>
                            <div>
                                <p class="text-light-text-color text-xxs">volunteers</p>
                                <p class="text-dark-text-color font-semibold text-lg">485</p>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($project->tags()->count() > 0)
                    <div class="flex justify-start space-x-2 mt-2">
                        @foreach($project->tags as $tag)
                            <x-library::tag class=" bg-gray-700 text-xxs text-white uppercase">{{ $tag->name }}</x-library::tag>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <div class="lg:grid lg:grid-rows-1 lg:grid-cols-3 lg:gap-4">
            <div class="col-span-2 row-span-1 space-y-6 flex flex-col">
                <div class="flex-1 flex flex-col">
                    <p class="text-black font-semibold">About this Project</p>
                    <div class="flex-1 mt-4 bg-white p-4">
                        <p class="text-dark-text-color">{{ $project->content }}</p>
                    </div>
                </div>
                <!-- Post Tile -->
                @if (/* $this->recentPosts->count() */1)
                    <div>
                        <div class="flex justify-between items-center text-black font-semibold">
                            <p class="text-sm">Posts</p>
                            <a href="#" class="text-xs flex items-center">See all <x-heroicon-s-chevron-right class="ml-2 w-4 h-4" /></a>
                        </div>
                        <div class="space-y-2">
                            @foreach (\Modules\Social\Models\Post::take(2)->get() as $post)
                                <div class="bg-primary border border-neutral-light rounded p-4 flex space-x-4">
                                    <div class="w-1/3 bg-[url('https://source.unsplash.com/random')] bg-cover bg-no-repeat rounded-md">
                                    </div>
                                    <div class="w-2/3 space-y-2">
                                        <p class="text-dark-text-color font-semibold text-xs">{{ $post->title }}</p>
                                        <div class="flex items-center text-base-text-color">
                                            <x-heroicon-o-calendar class="h-5 w-5 mr-2" />
                                            <span class="text-neutral-900 text-xs">{{ $post->created_at->toFormattedDateString() }}</span>
                                        </div>
                                        <p class="text-light-text-color text-xs line-clamp-2">{{ $post->body }}</p>
                                        <div class="text-base-text-color text-xs flex items-center -space-x-1 pt-6">
                                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=1">
                                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=2">
                                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=3">
                                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=4">
                                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=5">
                                            <div class="h-6 w-6 rounded-full bg-neutral-light flex justify-center items-center text-xxs p-2">+5</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-span-1 row-span-1 space-y-6">
                <!-- Project Relevence -->
                <div>
                    <div>
                        <p class="text-black font-semibold">Is this project relevant to you?</p>
                        <div class="mt-4 bg-white p-4">
                            <p class="text-dark-text-color">{{ $project->target_audience ?? 'This project is open for anyone to join.' }}</p>
                        </div>
                    </div>
                </div>
                <!-- Project Location -->
                <div>
                    <div>
                        <p class="text-black font-semibold">Location</p>
                        <livewire:social::map />
                    </div>
                </div>
                <!-- Project Languages -->
                <div>
                    <div>
                        <p class="text-black font-semibold">Languages</p>
                        <div class="mt-4 bg-white p-4">
                            <p class="text-dark-text-color">English, Russian, German, Swahili</p>
                        </div>
                    </div>
                </div>
                <!-- Project Awards -->
                <div>
                    <div>
                        <div class="flex justify-between items-center text-black font-semibold">
                            <p class="text-sm">Awards</p>
                            <a href="#" class="text-xs flex items-center">See all <x-heroicon-s-chevron-right class="ml-2 w-4 h-4" /></a>
                        </div>
                        <div class="mt-4 space-x-2">
                            <div class="bg-white p-2 flex items-center">
                                <div class="rounded-full bg-gray-500 mr-4 p-2">
                                    <x-heroicon-s-academic-cap class="w-4 h-4" />
                                </div>
                                <p class="whitespace-nowrap">Gold user</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p class="text-black font-semibold">Project Reviews</p>
        <div class="lg:grid lg:grid-cols-2 lg:gap-4">
            <div class="col-span-1">
                <div class="bg-white p-4">
                    <p class="text-xxs">Overall Reviews:</p>
                    <div class="flex items-center space-x-2 text-xxs">
                        <div class="bg-black flex items-center rounded-md mr-1 p-1">
                            <div class="flex items-center text-white">
                                <x-heroicon-s-star class="w-4 h-4" />
                                {{ $project->reviewScore ?? '3758' }}
                            </div>
                        </div>
                        <span class="text-gray-400">{{ $project->reviewStatus ?? 'Overwhelmingly Positive' }} ({{ /* $project->reviews()->count */'296,418' }})</span>
                    </div>
                </div>
                <div>
                    <p class="text-xxs">Most Helpful Reviews</p>
                    <div class="flex justify-start items-start bg-primary border border-neutral-light p-4">
                        <div class="mr-2">
                            <img class="h-8 w-8 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=1" alt="Arlene McCoy" />
                        </div>
                        <div class="flex-1 space-y-2">
                            <p class="text-dark-text-color font-semibold text-sm">Arlene McCoy</p>
                            <p class="text-light-text-color text-xs">Courtney was very helpful in setting up and an amazing person to be around!</p>
                        </div>
                        <div class="flex text-light-text-color">
                            <x-heroicon-s-star class="h-5 w-5" />
                            <x-heroicon-s-star class="h-5 w-5" />
                            <x-heroicon-s-star class="h-5 w-5" />
                            <x-heroicon-s-star class="h-5 w-5" />
                            <x-heroicon-s-star class="h-5 w-5" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-1">
                <div class="bg-white p-4">
                    <p class="text-xxs">Recent Reviews:</p>
                    <div class="flex items-center space-x-2 text-xxs">
                        <div class="bg-black flex items-center rounded-md mr-1 p-1">
                            <div class="flex items-center text-white">
                                <x-heroicon-s-star class="w-4 h-4" />
                                {{ $project->reviewScore ?? '3758' }}
                            </div>
                        </div>
                        <span class="text-gray-400">{{ $project->reviewStatus ?? 'Overwhelmingly Positive' }} ({{ /* $project->reviews()->count */'2,418' }})</span>
                    </div>
                </div>
                <div>
                    <p>Recent Reviews</p>
                    <div class="flex justify-start items-start bg-primary border border-neutral-light p-4">
                        <div class="mr-2">
                            <img class="h-8 w-8 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=1" alt="Arlene McCoy" />
                        </div>
                        <div class="flex-1 space-y-2">
                            <p class="text-dark-text-color font-semibold text-sm">Arlene McCoy</p>
                            <p class="text-light-text-color text-xs">Courtney was very helpful in setting up and an amazing person to be around!</p>
                        </div>
                        <div class="flex text-light-text-color">
                            <x-heroicon-s-star class="h-5 w-5" />
                            <x-heroicon-s-star class="h-5 w-5" />
                            <x-heroicon-s-star class="h-5 w-5" />
                            <x-heroicon-s-star class="h-5 w-5" />
                            <x-heroicon-s-star class="h-5 w-5" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
