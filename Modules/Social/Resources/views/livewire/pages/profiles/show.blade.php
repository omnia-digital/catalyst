@extends('social::livewire.layouts.main-layout')

@section('content')
<div>
    <!-- Page Heading -->
    <div class="lg:grid lg:grid-cols-2 lg:gap-4">
        <!-- Profile Data -->
        <div class=" mt-0">
            <div class="flex justify-start">
                <div class="mr-2">
                    <img class="h-24 w-24 rounded-full" src="{{ $this->user?->profile_photo_url }}" alt="{{ $this->user->name }}" />
                </div>
                <div class="flex-1">
                    <div>
                        <div class="text-sm font-bold text-gray-900 mr-2">
                            <p>{{ $this->user->name }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-400">Role</p>
                                <div class="flex items-center text-gray-500">
                                    <x-heroicon-o-identification class="h-5 w-5 mr-2" />
                                    <span class="text-neutral-900 text-xs">Preacher</span>
                                </div>
                            </div>
                            <div>
                                <p class="text-gray-400">Location</p>
                                <div class="flex items-center text-gray-500">
                                    <x-heroicon-o-location-marker class="h-5 w-5 mr-2" />
                                    <span class="text-neutral-900 text-xs">Jacksonville, Florida, USA</span>
                                </div>
                            </div>
                            <div>
                                <p class="text-gray-400">Summary</p>
                                <div class="flex items-center text-gray-500">
                                    <x-heroicon-o-document-text class="h-5 w-5 mr-2" />
                                    <span class="text-neutral-900 text-xs">My Summary</span>
                                </div>
                            </div>
                            <div>
                                <p class="text-gray-400">Achievement</p>
                                <div class="flex items-center text-gray-500">
                                    <x-heroicon-o-academic-cap class="h-5 w-5 mr-2" />
                                    <span class="text-neutral-900 text-xs">CfaN Training – Bootcamp Fall 2021</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="mt-2 text-sm text-gray-700">
                <p class="text-gray-400">Bio</p>
                <p class="text-gray-900">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet. 
                    Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
            </div>
        </div>
        <!-- Rating and Awards -->
        <div class="mt-6 lg:mt-0">
            <!-- Rating -->
            <div class="flex text-sm font-bold text-gray-900 mr-2">
                <p class="font-semibold mr-4">Rating</p>
                <div class="bg-black flex items-center text-white rounded p-1">
                    <x-heroicon-s-star class="h-4 w-4 mr-1" />
                    <p class="text-xs">3758</p>
                </div>
            </div>
            <div class="grid grid-cols-4 mt-4">
                <div class="flex justify-start items-center">
                    <div class="bg-gray-300 text-gray-400 mr-2 p-2">
                        <x-heroicon-o-heart class="h-5 w-5" />
                    </div>
                    <div>
                        <p class="text-gray-900 font-semibold text-xs">43</p>
                        <p class="text-gray-400 text-xs">Likes</p>
                    </div>
                </div>
                <div class="flex justify-start items-center">
                    <div class="bg-gray-300 text-gray-400 mr-2 p-2">
                        <x-heroicon-o-chat-alt class="h-5 w-5" />
                    </div>
                    <div>
                        <p class="text-gray-900 font-semibold text-xs">27</p>
                        <p class="text-gray-400 text-xs">Comments</p>
                    </div>
                </div>
                <div class="flex justify-start items-center">
                    <div class="bg-gray-300 text-gray-400 mr-2 p-2">
                        <x-heroicon-o-share class="h-5 w-5" />
                    </div>
                    <div>
                        <p class="text-gray-900 font-semibold text-xs">52</p>
                        <p class="text-gray-400 text-xs">Shares</p>
                    </div>
                </div>
                <div class="flex justify-start items-center">
                    <div class="bg-gray-300 text-gray-400 mr-2 p-2">
                        <x-heroicon-o-question-mark-circle class="h-5 w-5" />
                    </div>
                    <div>
                        <p class="text-gray-900 font-semibold text-xs">28</p>
                        <p class="text-gray-400 text-xs">Questions answered</p>
                    </div>
                </div>
            </div>
            <!-- Awards -->
            <div class="flex justify-between text-sm text-gray-900 mt-6">
                <p class="font-semibold">Awards</p>
                <div class="flex items-center text-gray-900">
                    <p class="text-sm mr-2">See all</p>
                    <x-heroicon-o-chevron-right class="h-4 w-4" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div class="flex justify-start items-start bg-white border border-gray-200 p-4 rounded">
                    <div class="bg-gray-400 text-gray-900 rounded-full mr-2 p-2">
                        <x-heroicon-o-academic-cap class="h-5 w-5" />
                    </div>
                    <div class="space-y-2">
                        <p class="text-gray-900 font-semibold text-xs">Gold user</p>
                        <div class="text-gray-400 text-xs flex items-center">
                            <x-heroicon-o-calendar class="h-4 w-4 mr-2" />
                            <p>Unlock 24 Feb'22</p>
                        </div>
                        <p class="text-gray-400 text-xs">Courtney Henry became a gold user</p>
                    </div>
                </div>
                <div class="flex justify-start items-start bg-white border border-gray-200 p-4 rounded">
                    <div class="bg-gray-400 text-gray-900 rounded-full mr-2 p-2">
                        <x-heroicon-o-academic-cap class="h-5 w-5" />
                    </div>
                    <div class="space-y-2">
                        <p class="text-gray-900 font-semibold text-xs">Gold user</p>
                        <div class="text-gray-400 text-xs flex items-center">
                            <x-heroicon-o-calendar class="h-4 w-4 mr-2" />
                            <p>Unlock 24 Feb'22</p>
                        </div>
                        <p class="text-gray-400 text-xs">Courtney Henry became a gold user</p>
                    </div>
                </div>
                <div class="flex justify-start items-start bg-white border border-gray-200 p-4 rounded">
                    <div class="bg-gray-400 text-gray-900 rounded-full mr-2 p-2">
                        <x-heroicon-o-academic-cap class="h-5 w-5" />
                    </div>
                    <div class="space-y-2">
                        <p class="text-gray-900 font-semibold text-xs">Gold user</p>
                        <div class="text-gray-400 text-xs flex items-center">
                            <x-heroicon-o-calendar class="h-4 w-4 mr-2" />
                            <p>Unlock 24 Feb'22</p>
                        </div>
                        <p class="text-gray-400 text-xs">Courtney Henry became a gold user</p>
                    </div>
                </div>
                <div class="flex justify-start items-start bg-white border border-gray-200 p-4 rounded">
                    <div class="bg-gray-400 text-gray-900 rounded-full mr-2 p-2">
                        <x-heroicon-o-academic-cap class="h-5 w-5" />
                    </div>
                    <div class="space-y-2">
                        <p class="text-gray-900 font-semibold text-xs">Gold user</p>
                        <div class="text-gray-400 text-xs flex items-center">
                            <x-heroicon-o-calendar class="h-4 w-4 mr-2" />
                            <p>Unlock 24 Feb'22</p>
                        </div>
                        <p class="text-gray-400 text-xs">Courtney Henry became a gold user</p>
                    </div>
                </div>
                
            </div>
        </div>
        <!-- Initiatives -->
        <div class="mt-6">
            <div class="flex justify-between text-sm text-gray-900">
                <p class="font-semibold">Initiatives <span class="bg-gray-400 text-xs rounded-full ml-2 p-1">24</span></p>
                <div class="flex items-center text-gray-900">
                    <p class="text-sm mr-2">See all</p>
                    <x-heroicon-o-chevron-right class="h-4 w-4" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div class="flex justify-start items-start bg-white border border-gray-200 p-4 rounded">
                    <div class="space-y-2">
                        <p class="text-gray-900 font-semibold text-xs">Initiative title</p>
                        <div class="flex items-center text-gray-500">
                            <x-heroicon-o-location-marker class="h-5 w-5 mr-2" />
                            <span class="text-neutral-900 text-xs">Jacksonville, Florida, USA</span>
                        </div>
                        <p class="text-gray-400 text-xs line-clamp-3">Tincidunt dolor odio vulputate faucibus tempor. Nunc ullamcorper nunc eget eget orci, congue. Tincidunt dolor odio vulputate faucibus tempor.</p>
                        <div class="text-gray-600 text-xs flex items-center space-x-4 pt-6">
                            <div class="flex items-center">
                                <x-heroicon-o-users class="h-4 w-4 mr-2" />
                                <p>25</p>
                            </div>
                            <div class="flex items-center">
                                <x-heroicon-o-calendar class="h-4 w-4 mr-2" />
                                <p>Dec 02, 2021</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-start items-start bg-white border border-gray-200 p-4 rounded">
                    <div class="space-y-2">
                        <p class="text-gray-900 font-semibold text-xs">Another initiative title</p>
                        <div class="flex items-center text-gray-500">
                            <x-heroicon-o-location-marker class="h-5 w-5 mr-2" />
                            <span class="text-neutral-900 text-xs">Pittsburgh Pennsylvania, USA</span>
                        </div>
                        <p class="text-gray-400 text-xs line-clamp-3">Pellentesque nulla ante elit phasellus sagittis, non in. In vel, ac, tristique ac orci lectus maecenas morbi in. Tincidunt dolor odio vulputate faucibus tempor.</p>
                        <div class="text-gray-600 text-xs flex items-center space-x-4 pt-6">
                            <div class="flex items-center">
                                <x-heroicon-o-users class="h-4 w-4 mr-2" />
                                <p>25</p>
                            </div>
                            <div class="flex items-center">
                                <x-heroicon-o-calendar class="h-4 w-4 mr-2" />
                                <p>Dec 02, 2021</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-start items-start bg-white border border-gray-200 p-4 rounded">
                    <div class="space-y-2">
                        <p class="text-gray-900 font-semibold text-xs">Tincidunt dolor odio vulputate faucibus tempor. Nunc ullamcorper nunc</p>
                        <div class="flex items-center text-gray-500">
                            <x-heroicon-o-location-marker class="h-5 w-5 mr-2" />
                            <span class="text-neutral-900 text-xs">St. Louis Missouri, USA</span>
                        </div>
                        <p class="text-gray-400 text-xs line-clamp-3">Proin augue feugiat arcu scelerisque integer. Lacus, senectus ornare proin morbi sem nisi. Tincidunt dolor odio vulputate faucibus tempor.</p>
                        <div class="text-gray-600 text-xs flex items-center space-x-4 pt-6">
                            <div class="flex items-center">
                                <x-heroicon-o-users class="h-4 w-4 mr-2" />
                                <p>25</p>
                            </div>
                            <div class="flex items-center">
                                <x-heroicon-o-calendar class="h-4 w-4 mr-2" />
                                <p>Dec 02, 2021</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-start items-start bg-white border border-gray-200 p-4 rounded">
                    <div class="space-y-2">
                        <p class="text-gray-900 font-semibold text-xs">Initiative title</p>
                        <div class="flex items-center text-gray-500">
                            <x-heroicon-o-location-marker class="h-5 w-5 mr-2" />
                            <span class="text-neutral-900 text-xs">Raleigh North Carolina, USA</span>
                        </div>
                        <p class="text-gray-400 text-xs line-clamp-3">Tincidunt dolor odio vulputate faucibus tempor. Nunc ullamcorper nunc eget eget orci, congue. Tincidunt dolor odio vulputate faucibus tempor.</p>
                        <div class="text-gray-600 text-xs flex items-center space-x-4 pt-6">
                            <div class="flex items-center">
                                <x-heroicon-o-users class="h-4 w-4 mr-2" />
                                <p>25</p>
                            </div>
                            <div class="flex items-center">
                                <x-heroicon-o-calendar class="h-4 w-4 mr-2" />
                                <p>Dec 02, 2021</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Reviews -->
        <div class="mt-6">
            <div class="flex justify-between text-sm text-gray-900">
                <p class="font-semibold">Reviews</p>
                <div class="flex items-center text-gray-900">
                    <p class="text-sm mr-2">See all</p>
                    <x-heroicon-o-chevron-right class="h-4 w-4" />
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 mt-4">
                <div class="flex justify-start items-start bg-white border border-gray-200 p-4">
                    <div class="mr-2">
                        <img class="h-8 w-8 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=1" alt="Arlene McCoy" />
                    </div>
                    <div class="flex-1 space-y-2">
                        <p class="text-gray-900 font-semibold text-sm">Arlene McCoy</p>
                        <p class="text-gray-400 text-xs">Courtney was very helpful in setting up and an amazing person to be around!</p>
                    </div>
                    <div class="flex text-gray-400">
                        <x-heroicon-s-star class="h-5 w-5" />
                        <x-heroicon-s-star class="h-5 w-5" />
                        <x-heroicon-s-star class="h-5 w-5" />
                        <x-heroicon-s-star class="h-5 w-5" />
                        <x-heroicon-s-star class="h-5 w-5" />
                    </div>
                </div>
                <div class="flex justify-start items-start bg-white border border-gray-200 p-4">
                    <div class="mr-2">
                        <img class="h-8 w-8 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=2" alt="Darrell Steward" />
                    </div>
                    <div class="flex-1 space-y-2">
                        <p class="text-gray-900 font-semibold text-sm">Darrell Steward</p>
                        <p class="text-gray-400 text-xs">Courtney really is a good professional!</p>
                    </div>
                    <div class="flex text-gray-400">
                        <x-heroicon-s-star class="h-5 w-5" />
                        <x-heroicon-s-star class="h-5 w-5" />
                        <x-heroicon-s-star class="h-5 w-5" />
                        <x-heroicon-s-star class="h-5 w-5" />
                        <x-heroicon-s-star class="h-5 w-5" />
                    </div>
                </div>
                <div class="flex justify-start items-start bg-white border border-gray-200 p-4">
                    <div class="mr-2">
                        <img class="h-8 w-8 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=3" alt="Albert Flores" />
                    </div>
                    <div class="flex-1 space-y-2">
                        <p class="text-gray-900 font-semibold text-sm">Albert Flores</p>
                        <p class="text-gray-400 text-xs">Courtney was very helpful in setting up and an amazing person to be around!</p>
                    </div>
                    <div class="flex text-gray-400">
                        <x-heroicon-s-star class="h-5 w-5" />
                        <x-heroicon-s-star class="h-5 w-5" />
                        <x-heroicon-s-star class="h-5 w-5" />
                        <x-heroicon-s-star class="h-5 w-5" />
                        <x-heroicon-s-star class="h-5 w-5" />
                    </div>
                </div>
                <div class="flex justify-start items-start bg-white border border-gray-200 p-4">
                    <div class="mr-2">
                        <img class="h-8 w-8 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=4" alt="Albert Flores" />
                    </div>
                    <div class="flex-1 space-y-2">
                        <p class="text-gray-900 font-semibold text-sm">Albert Flores</p>
                        <p class="text-gray-400 text-xs">Courtney was very helpful in setting up and an amazing person to be around!</p>
                    </div>
                    <div class="flex text-gray-400">
                        <x-heroicon-s-star class="h-5 w-5" />
                        <x-heroicon-s-star class="h-5 w-5" />
                        <x-heroicon-s-star class="h-5 w-5" />
                        <x-heroicon-s-star class="h-5 w-5" />
                        <x-heroicon-s-star class="h-5 w-5" />
                    </div>
                </div>
            </div>
        </div>
        <!-- Posts -->
        <div class="col-span-2 mt-0">
            <div class="flex justify-between text-sm text-gray-900 mt-6">
                <p class="font-semibold">Posts <span class="bg-gray-400 text-xs rounded-full ml-2 p-1">24</span></p>
                <div class="flex items-center text-gray-900">
                    <p class="text-sm mr-2">See all</p>
                    <x-heroicon-o-chevron-right class="h-4 w-4" />
                </div>
            </div>
            <div class="grid grid-cols-4 gap-4 mt-4">
                <!-- Post Tile -->
                <div class="bg-white border border-gray-200 rounded">
                    <div class="h-36 bg-[url('https://source.unsplash.com/random')] bg-cover bg-no-repeat">
                    </div>
                    <div class="space-y-2 p-4">
                        <p class="text-gray-900 font-semibold text-xs">New Year Celebration</p>
                        <div class="flex items-center text-gray-500">
                            <x-heroicon-o-calendar class="h-5 w-5 mr-2" />
                            <span class="text-neutral-900 text-xs">24 Feb'22</span>
                        </div>
                        <p class="text-gray-400 text-xs line-clamp-2">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Tincidunt dolor odio vulputate faucibus tempor.</p>
                        <div class="text-gray-600 text-xs flex items-center -space-x-1 pt-6">
                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=1">
                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=2">
                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=3">
                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=4">
                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=5">
                            <div class="h-6 w-6 rounded-full bg-gray-200 flex justify-center items-center text-xxs p-2">+5</div>
                        </div>
                    </div>
                </div>
                <!-- Post Tile -->
                <div class="bg-white border border-gray-200 rounded">
                    <div class="h-36 bg-[url('https://source.unsplash.com/random')] bg-cover bg-no-repeat">
                    </div>
                    <div class="space-y-2 p-4">
                        <p class="text-gray-900 font-semibold text-xs">New Year Celebration</p>
                        <div class="flex items-center text-gray-500">
                            <x-heroicon-o-calendar class="h-5 w-5 mr-2" />
                            <span class="text-neutral-900 text-xs">24 Feb'22</span>
                        </div>
                        <p class="text-gray-400 text-xs line-clamp-2">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Tincidunt dolor odio vulputate faucibus tempor.</p>
                        <div class="text-gray-600 text-xs flex items-center -space-x-1 pt-6">
                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=1">
                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=2">
                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=3">
                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=4">
                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=5">
                            <div class="h-6 w-6 rounded-full bg-gray-200 flex justify-center items-center text-xxs p-2">+5</div>
                        </div>
                    </div>
                </div>
                <!-- Post Tile -->
                <div class="bg-white border border-gray-200 rounded">
                    <div class="h-36 bg-[url('https://source.unsplash.com/random')] bg-cover bg-no-repeat">
                    </div>
                    <div class="space-y-2 p-4">
                        <p class="text-gray-900 font-semibold text-xs">New Year Celebration</p>
                        <div class="flex items-center text-gray-500">
                            <x-heroicon-o-calendar class="h-5 w-5 mr-2" />
                            <span class="text-neutral-900 text-xs">24 Feb'22</span>
                        </div>
                        <p class="text-gray-400 text-xs line-clamp-2">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Tincidunt dolor odio vulputate faucibus tempor.</p>
                        <div class="text-gray-600 text-xs flex items-center -space-x-1 pt-6">
                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=1">
                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=2">
                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=3">
                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=4">
                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=5">
                            <div class="h-6 w-6 rounded-full bg-gray-200 flex justify-center items-center text-xxs p-2">+5</div>
                        </div>
                    </div>
                </div>
                <!-- Post Tile -->
                <div class="bg-white border border-gray-200 rounded">
                    <div class="h-36 bg-[url('https://source.unsplash.com/random')] bg-cover bg-no-repeat">
                    </div>
                    <div class="space-y-2 p-4">
                        <p class="text-gray-900 font-semibold text-xs">New Year Celebration</p>
                        <div class="flex items-center text-gray-500">
                            <x-heroicon-o-calendar class="h-5 w-5 mr-2" />
                            <span class="text-neutral-900 text-xs">24 Feb'22</span>
                        </div>
                        <p class="text-gray-400 text-xs line-clamp-2">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Tincidunt dolor odio vulputate faucibus tempor.</p>
                        <div class="text-gray-600 text-xs flex items-center -space-x-1 pt-6">
                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=1">
                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=2">
                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=3">
                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=4">
                            <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=5">
                            <div class="h-6 w-6 rounded-full bg-gray-200 flex justify-center items-center text-xxs p-2">+5</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
