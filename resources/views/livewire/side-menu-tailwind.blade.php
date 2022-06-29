
<div class="min-h-full">
    <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
    <div class="fixed inset-0 flex z-40 lg:hidden" role="dialog" aria-modal="true">
        <!--
          Off-canvas menu overlay, show/hide based on off-canvas menu state.

          Entering: "transition-opacity ease-linear duration-300"
            From: "opacity-0"
            To: "opacity-100"
          Leaving: "transition-opacity ease-linear duration-300"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true"></div>

        <!--
          Off-canvas menu, show/hide based on off-canvas menu state.

          Entering: "transition ease-in-out duration-300 transform"
            From: "-translate-x-full"
            To: "translate-x-0"
          Leaving: "transition ease-in-out duration-300 transform"
            From: "translate-x-0"
            To: "-translate-x-full"
        -->
        <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-primary">
            <!--
              Close button, show/hide based on off-canvas menu state.

              Entering: "ease-in-out duration-300"
                From: "opacity-0"
                To: "opacity-100"
              Leaving: "ease-in-out duration-300"
                From: "opacity-100"
                To: "opacity-0"
            -->
            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <span class="sr-only">Close sidebar</span>
                    <!-- Heroicon name: outline/x -->
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex-shrink-0 flex items-center px-4">
                <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-logo-purple-500-mark-gray-700-text.svg" alt="Workflow">
            </div>
            <div class="mt-5 flex-1 h-0 overflow-y-auto">
                <nav class="px-2">
                    <div class="space-y-1">
                        <!-- Current: "bg-neutral text-dark-text-color", Default: "text-base-text-color hover:text-dark-text-color hover:bg-gray-50" -->
                        <a href="#" class="bg-neutral text-dark-text-color group flex items-center px-2 py-2 text-base-text-color leading-5 font-medium rounded-md" aria-current="page">
                            <!--
                              Heroicon name: outline/home

                              Current: "text-base-text-color", Default: "text-light-text-color group-hover:text-base-text-color"
                            -->
                            <svg class="text-base-text-color mr-3 flex-shrink-0 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Home
                        </a>

                        <a href="#" class="text-base-text-color hover:text-dark-text-color hover:bg-gray-50 group flex items-center px-2 py-2 text-base-text-color leading-5 font-medium rounded-md">
                            <!-- Heroicon name: outline/view-list -->
                            <svg class="text-light-text-color group-hover:text-base-text-color mr-3 flex-shrink-0 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                            My tasks
                        </a>

                        <a href="#" class="text-base-text-color hover:text-dark-text-color hover:bg-gray-50 group flex items-center px-2 py-2 text-base-text-color leading-5 font-medium rounded-md">
                            <!-- Heroicon name: outline/clock -->
                            <svg class="text-light-text-color group-hover:text-base-text-color mr-3 flex-shrink-0 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Recent
                        </a>
                    </div>
                    <div class="mt-8">
                        <h3 class="px-3 text-xs font-semibold text-base-text-color uppercase tracking-wider" id="mobile-teams-headline">Teams</h3>
                        <div class="mt-1 space-y-1" role="group" aria-labelledby="mobile-teams-headline">
                            <a href="#" class="group flex items-center px-3 py-2 text-base-text-color leading-5 font-medium text-base-text-color rounded-md hover:text-dark-text-color hover:bg-gray-50">
                                <span class="w-2.5 h-2.5 mr-4 bg-secondary rounded-full" aria-hidden="true"></span>
                                <span class="truncate"> Engineering </span>
                            </a>

                            <a href="#" class="group flex items-center px-3 py-2 text-base-text-color leading-5 font-medium text-base-text-color rounded-md hover:text-dark-text-color hover:bg-gray-50">
                                <span class="w-2.5 h-2.5 mr-4 bg-green-500 rounded-full" aria-hidden="true"></span>
                                <span class="truncate"> Human Resources </span>
                            </a>

                            <a href="#" class="group flex items-center px-3 py-2 text-base-text-color leading-5 font-medium text-base-text-color rounded-md hover:text-dark-text-color hover:bg-gray-50">
                                <span class="w-2.5 h-2.5 mr-4 bg-yellow-500 rounded-full" aria-hidden="true"></span>
                                <span class="truncate"> Customer Success </span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div class="flex-shrink-0 w-14" aria-hidden="true">
            <!-- Dummy element to force sidebar to shrink to fit close icon -->
        </div>
    </div>

    <!-- Static sidebar for desktop -->
    <div class="hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-0 lg:border-r lg:border-neutral-light lg:pt-5 lg:pb-4 lg:bg-neutral">
        <div class="flex items-center flex-shrink-0 px-6">
            <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-logo-purple-500-mark-gray-700-text.svg" alt="Workflow">
        </div>
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="mt-6 h-0 flex-1 flex flex-col overflow-y-auto">
            <!-- User account dropdown -->
            <div class="px-3 relative inline-block text-left">
                <div>
                    <button type="button" class="group w-full bg-neutral rounded-md px-3.5 py-2 text-sm text-left font-medium text-dark-text-color hover:bg-neutral-light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-purple-500" id="options-menu-button" aria-expanded="false" aria-haspopup="true">
            <span class="flex w-full justify-between items-center">
              <span class="flex min-w-0 items-center justify-between space-x-3">
                <img class="w-10 h-10 bg-neutral-dark rounded-full flex-shrink-0" src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80" alt="">
                <span class="flex-1 flex flex-col min-w-0">
                  <span class="text-dark-text-color text-sm font-medium truncate">Jessy Schwarz</span>
                  <span class="text-base-text-color text-sm truncate">@jessyschwarz</span>
                </span>
              </span>
                <!-- Heroicon name: solid/selector -->
              <svg class="flex-shrink-0 h-5 w-5 text-light-text-color group-hover:text-base-text-color" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </span>
                    </button>
                </div>

                <!--
                  Dropdown menu, show/hide based on menu state.

                  Entering: "transition ease-out duration-100"
                    From: "transform opacity-0 scale-95"
                    To: "transform opacity-100 scale-100"
                  Leaving: "transition ease-in duration-75"
                    From: "transform opacity-100 scale-100"
                    To: "transform opacity-0 scale-95"
                -->
                <div class="z-10 mx-3 origin-top absolute right-0 left-0 mt-1 rounded-md shadow-lg bg-primary ring-1 ring-black ring-opacity-5 divide-y divide-neutral-light focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="options-menu-button" tabindex="-1">
                    <div class="py-1" role="none">
                        <!-- Active: "bg-neutral text-dark-text-color", Not Active: "text-dark-text-color" -->
                        <a href="#" class="text-dark-text-color block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="options-menu-item-0">View profile</a>
                        <a href="#" class="text-dark-text-color block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="options-menu-item-1">Settings</a>
                        <a href="#" class="text-dark-text-color block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="options-menu-item-2">Notifications</a>
                    </div>
                    <div class="py-1" role="none">
                        <a href="#" class="text-dark-text-color block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="options-menu-item-3">Get desktop app</a>
                        <a href="#" class="text-dark-text-color block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="options-menu-item-4">Support</a>
                    </div>
                    <div class="py-1" role="none">
                        <a href="#" class="text-dark-text-color block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="options-menu-item-5">Logout</a>
                    </div>
                </div>
            </div>
            <!-- Sidebar Search -->
            <div class="px-3 mt-5">
                <label for="search" class="sr-only">Search</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none" aria-hidden="true">
                        <!-- Heroicon name: solid/search -->
                        <svg class="mr-3 h-4 w-4 text-light-text-color" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="search" id="search" class="focus:ring-secondary focus:border-secondary block w-full pl-9 sm:text-sm border-gray-300 rounded-md" placeholder="Search">
                </div>
            </div>
            <!-- Navigation -->
            <nav class="px-3 mt-6">
                <div class="space-y-1">
                    <!-- Current: "bg-neutral-light text-dark-text-color", Default: "text-dark-text-color hover:text-dark-text-color hover:bg-gray-50" -->
                    <a href="#" class="bg-neutral-light text-dark-text-color group flex items-center px-2 py-2 text-sm font-medium rounded-md" aria-current="page">
                        <!--
                          Heroicon name: outline/home

                          Current: "text-base-text-color", Default: "text-light-text-color group-hover:text-base-text-color"
                        -->
                        <svg class="text-base-text-color mr-3 flex-shrink-0 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Home
                    </a>

                    <a href="#" class="text-dark-text-color hover:text-dark-text-color hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <!-- Heroicon name: outline/view-list -->
                        <svg class="text-light-text-color group-hover:text-base-text-color mr-3 flex-shrink-0 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        My tasks
                    </a>

                    <a href="#" class="text-dark-text-color hover:text-dark-text-color hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <!-- Heroicon name: outline/clock -->
                        <svg class="text-light-text-color group-hover:text-base-text-color mr-3 flex-shrink-0 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Recent
                    </a>
                </div>
                <div class="mt-8">
                    <!-- Secondary navigation -->
                    <h3 class="px-3 text-xs font-semibold text-base-text-color uppercase tracking-wider" id="desktop-teams-headline">Teams</h3>
                    <div class="mt-1 space-y-1" role="group" aria-labelledby="desktop-teams-headline">
                        <a href="#" class="group flex items-center px-3 py-2 text-sm font-medium text-dark-text-color rounded-md hover:text-dark-text-color hover:bg-gray-50">
                            <span class="w-2.5 h-2.5 mr-4 bg-secondary rounded-full" aria-hidden="true"></span>
                            <span class="truncate"> Engineering </span>
                        </a>

                        <a href="#" class="group flex items-center px-3 py-2 text-sm font-medium text-dark-text-color rounded-md hover:text-dark-text-color hover:bg-gray-50">
                            <span class="w-2.5 h-2.5 mr-4 bg-green-500 rounded-full" aria-hidden="true"></span>
                            <span class="truncate"> Human Resources </span>
                        </a>

                        <a href="#" class="group flex items-center px-3 py-2 text-sm font-medium text-dark-text-color rounded-md hover:text-dark-text-color hover:bg-gray-50">
                            <span class="w-2.5 h-2.5 mr-4 bg-yellow-500 rounded-full" aria-hidden="true"></span>
                            <span class="truncate"> Customer Success </span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Main column -->
    <div class="lg:pl-64 flex flex-col">
        <!-- Search header -->
        <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-primary border-b border-neutral-light lg:hidden">
            <!-- Sidebar toggle, controls the 'sidebarOpen' sidebar state. -->
            <button type="button" class="px-4 border-r border-neutral-light text-base-text-color focus:outline-none focus:ring-2 focus:ring-inset focus:ring-purple-500 lg:hidden">
                <span class="sr-only">Open sidebar</span>
                <!-- Heroicon name: outline/menu-alt-1 -->
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                </svg>
            </button>
            <div class="flex-1 flex justify-between px-4 sm:px-6 lg:px-8">
                <div class="flex-1 flex">
                    <form class="w-full flex md:ml-0" action="#" method="GET">
                        <label for="search-field" class="sr-only">Search</label>
                        <div class="relative w-full text-light-text-color focus-within:text-base-text-color">
                            <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                                <!-- Heroicon name: solid/search -->
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="search-field" name="search-field" class="block w-full h-full pl-8 pr-3 py-2 border-transparent text-dark-text-color placeholder-gray-500 focus:outline-none focus:ring-0 focus:border-transparent focus:placeholder-gray-400 sm:text-sm" placeholder="Search" type="search">
                        </div>
                    </form>
                </div>
                <div class="flex items-center">
                    <!-- Profile dropdown -->
                    <div class="ml-3 relative">
                        <div>
                            <button type="button" class="max-w-xs bg-primary flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            </button>
                        </div>

                        <!--
                          Dropdown menu, show/hide based on menu state.

                          Entering: "transition ease-out duration-100"
                            From: "transform opacity-0 scale-95"
                            To: "transform opacity-100 scale-100"
                          Leaving: "transition ease-in duration-75"
                            From: "transform opacity-100 scale-100"
                            To: "transform opacity-0 scale-95"
                        -->
                        <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-primary ring-1 ring-black ring-opacity-5 divide-y divide-neutral-light focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <div class="py-1" role="none">
                                <!-- Active: "bg-neutral text-dark-text-color", Not Active: "text-dark-text-color" -->
                                <a href="#" class="text-dark-text-color block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="user-menu-item-0">View profile</a>
                                <a href="#" class="text-dark-text-color block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>
                                <a href="#" class="text-dark-text-color block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="user-menu-item-2">Notifications</a>
                            </div>
                            <div class="py-1" role="none">
                                <a href="#" class="text-dark-text-color block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="user-menu-item-3">Get desktop app</a>
                                <a href="#" class="text-dark-text-color block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="user-menu-item-4">Support</a>
                            </div>
                            <div class="py-1" role="none">
                                <a href="#" class="text-dark-text-color block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="user-menu-item-5">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <main class="flex-1">
            <!-- Page title & actions -->
            <div class="border-b border-neutral-light px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
                <div class="flex-1 min-w-0">
                    <h1 class="text-lg font-medium leading-6 text-dark-text-color sm:truncate">Home</h1>
                </div>
                <div class="mt-4 flex sm:mt-0 sm:ml-4">
                    <button type="button" class="order-1 ml-3 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-dark-text-color bg-primary hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:order-0 sm:ml-0">Share</button>
                    <button type="button" class="order-0 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:order-1 sm:ml-3">Create</button>
                </div>
            </div>
            <!-- Pinned teams -->
            <div class="px-4 mt-6 sm:px-6 lg:px-8">
                <h2 class="text-base-text-color text-xs font-medium uppercase tracking-wide">Pinned Teams</h2>
                <ul role="list" class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2 xl:grid-cols-4 mt-3">
                    <li class="relative col-span-1 flex shadow-sm rounded-md">
                        <div class="flex-shrink-0 flex items-center justify-center w-16 bg-pink-600 text-white text-sm font-medium rounded-l-md">GA</div>
                        <div class="flex-1 flex items-center justify-between border-t border-r border-b border-neutral-light bg-primary rounded-r-md truncate">
                            <div class="flex-1 px-4 py-2 text-sm truncate">
                                <a href="#" class="text-dark-text-color font-medium hover:text-base-text-color"> GraphQL API </a>
                                <p class="text-base-text-color">12 Members</p>
                            </div>
                            <div class="flex-shrink-0 pr-2">
                                <button type="button" class="w-8 h-8 bg-primary inline-flex items-center justify-center text-light-text-color rounded-full hover:text-base-text-color focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500" id="pinned-team-options-menu-0-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open options</span>
                                    <!-- Heroicon name: solid/dots-vertical -->
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                    </svg>
                                </button>

                                <!--
                                  Dropdown menu, show/hide based on menu state.

                                  Entering: "transition ease-out duration-100"
                                    From: "transform opacity-0 scale-95"
                                    To: "transform opacity-100 scale-100"
                                  Leaving: "transition ease-in duration-75"
                                    From: "transform opacity-100 scale-100"
                                    To: "transform opacity-0 scale-95"
                                -->
                                <div class="z-10 mx-3 origin-top-right absolute right-10 top-3 w-48 mt-1 rounded-md shadow-lg bg-primary ring-1 ring-black ring-opacity-5 divide-y divide-neutral-light focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="pinned-team-options-menu-0-button" tabindex="-1">
                                    <div class="py-1" role="none">
                                        <!-- Active: "bg-neutral text-dark-text-color", Not Active: "text-dark-text-color" -->
                                        <a href="#" class="text-dark-text-color block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="pinned-team-options-menu-0-item-0">View</a>
                                    </div>
                                    <div class="py-1" role="none">
                                        <a href="#" class="text-dark-text-color block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="pinned-team-options-menu-0-item-1">Removed from pinned</a>
                                        <a href="#" class="text-dark-text-color block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="pinned-team-options-menu-0-item-2">Share</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <!-- More items... -->
                </ul>
            </div>

            <!-- Teams list (only on smallest breakpoint) -->
            <div class="mt-10 sm:hidden">
                <div class="px-4 sm:px-6">
                    <h2 class="text-base-text-color text-xs font-medium uppercase tracking-wide">Teams</h2>
                </div>
                <ul role="list" class="mt-3 border-t border-neutral-light divide-y divide-gray-100">
                    <li>
                        <a href="#" class="group flex items-center justify-between px-4 py-4 hover:bg-gray-50 sm:px-6">
              <span class="flex items-center truncate space-x-3">
                <span class="w-2.5 h-2.5 flex-shrink-0 rounded-full bg-pink-600" aria-hidden="true"></span>
                <span class="font-medium truncate text-sm leading-6">
                  GraphQL API
                  <span class="truncate font-normal text-base-text-color">in Engineering</span>
                </span>
              </span>
                            <!-- Heroicon name: solid/chevron-right -->
                            <svg class="ml-4 h-5 w-5 text-light-text-color group-hover:text-base-text-color" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </li>

                    <!-- More teams... -->
                </ul>
            </div>

            <!-- Teams table (small breakpoint and up) -->
            <div class="hidden mt-8 sm:block">
                <div class="align-middle inline-block min-w-full border-b border-neutral-light">
                    <table class="min-w-full">
                        <thead>
                        <tr class="border-t border-neutral-light">
                            <th class="px-6 py-3 border-b border-neutral-light bg-gray-50 text-left text-xs font-medium text-base-text-color uppercase tracking-wider">
                                <span class="lg:pl-2">Team</span>
                            </th>
                            <th class="px-6 py-3 border-b border-neutral-light bg-gray-50 text-left text-xs font-medium text-base-text-color uppercase tracking-wider">Members</th>
                            <th class="hidden md:table-cell px-6 py-3 border-b border-neutral-light bg-gray-50 text-right text-xs font-medium text-base-text-color uppercase tracking-wider">Last updated</th>
                            <th class="pr-6 py-3 border-b border-neutral-light bg-gray-50 text-right text-xs font-medium text-base-text-color uppercase tracking-wider"></th>
                        </tr>
                        </thead>
                        <tbody class="bg-primary divide-y divide-gray-100">
                        <tr>
                            <td class="px-6 py-3 max-w-0 w-full whitespace-nowrap text-sm font-medium text-dark-text-color">
                                <div class="flex items-center space-x-3 lg:pl-2">
                                    <div class="flex-shrink-0 w-2.5 h-2.5 rounded-full bg-pink-600" aria-hidden="true"></div>
                                    <a href="#" class="truncate hover:text-base-text-color">
                      <span>
                        GraphQL API
                        <span class="text-base-text-color font-normal">in Engineering</span>
                      </span>
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-sm text-base-text-color font-medium">
                                <div class="flex items-center space-x-2">
                                    <div class="flex flex-shrink-0 -space-x-1">
                                        <img class="max-w-none h-6 w-6 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Dries Vincent">

                                        <img class="max-w-none h-6 w-6 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Lindsay Walton">

                                        <img class="max-w-none h-6 w-6 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Courtney Henry">

                                        <img class="max-w-none h-6 w-6 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Tom Cook">
                                    </div>

                                    <span class="flex-shrink-0 text-xs leading-5 font-medium">+8</span>
                                </div>
                            </td>
                            <td class="hidden md:table-cell px-6 py-3 whitespace-nowrap text-sm text-base-text-color text-right">March 17, 2020</td>
                            <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">
                                <a href="#" class="text-secondary hover:text-secondary-dark">Edit</a>
                            </td>
                        </tr>

                        <!-- More teams... -->
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
