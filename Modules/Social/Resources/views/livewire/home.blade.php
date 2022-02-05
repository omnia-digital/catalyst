<div>
    <!-- Page Heading -->
    <div class="my-6 lg:grid lg:grid-cols-9 lg:gap-9">
        <div class="lg:col-span-6 xl:col-span-6">
            <div class="px-4 sm:px-0">
                <div class="sm:hidden">
                    <label for="question-tabs" class="sr-only">Select a tab</label>
                    <select id="question-tabs" class="block w-full rounded-md border-gray-300 text-base font-medium text-gray-900 shadow-sm focus:border-rose-500 focus:ring-rose-500">
                        @foreach ($tabs as $tab)
                            <option :selected="$tab['current']">{{ $tab['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="hidden sm:block">
                    <nav class="relative z-0 rounded-lg shadow flex divide-x divide-gray-200" aria-label="Tabs">
                        @foreach($tabs as $tab)
                            <x-sort-button :orderBy="$orderBy">
                                {{ $tab['name'] }}
                            </x-sort-button>
                        @endforeach
                    </nav>
                </div>
            </div>
            <div class="mt-4">
                <livewire:social::new-post-box class="my-6" :user="auth()->user()" />
                <h1 class="sr-only">Recent Posts</h1>
                <ul role="list" class="space-y-4">
                    @foreach ($questions as $question)
                        <li>
                            <livewire:social::post-list-item :post="$question" />
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
                <section aria-labelledby="who-to-follow-heading">
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6">
                            <h2 id="who-to-follow-heading" class="text-base font-medium text-gray-900">
                                Who to follow
                            </h2>
                            <div class="mt-6 flow-root">
                                <ul role="list" class="-my-4 divide-y divide-gray-200">
                                    @foreach ($whoToFollow as $user)
                                        <li class="flex items-center py-4 space-x-3">
                                            <div class="flex-shrink-0">
                                                <img class="h-8 w-8 rounded-full" src="{{ $user['imageUrl'] }}" alt="" />
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-medium text-gray-900">
                                                    <a href="{{ $user['href'] }}">{{ $user['name'] }}</a>
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    <a href="{{ $user['href'] }}">{{ '@' . $user['profile']['handle'] }}</a>
                                                </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <button type="button" class="inline-flex items-center px-3 py-0.5 rounded-full bg-rose-50 text-sm font-medium text-rose-700 hover:bg-rose-100">
                                                    <x-heroicon-o-plus-sm class="-ml-1 mr-0.5 h-5 w-5 text-rose-400" aria-hidden="true" />
                                                    <span>
                                                        Follow
                                                    </span>
                                                </button>
                                            </div>
                                        </li>
                                        
                                    @endforeach
                                </ul>
                            </div>
                            <div class="mt-6">
                                <a href="#" class="w-full block text-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    View all
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
                <section aria-labelledby="trending-heading">
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6">
                            <h2 id="trending-heading" class="text-base font-medium text-gray-900">
                                Trending
                            </h2>
                            <div class="mt-6 flow-root">
                                <ul role="list" class="-my-4 divide-y divide-gray-200">
                                    @foreach ($trendingPosts as $post)
                                        <li class="flex py-4 space-x-3">
                                            <div class="flex-shrink-0">
                                                <img class="h-8 w-8 rounded-full" src="{{ $post['user']['imageUrl'] }}" alt="{{ $post['user']['name'] }}"/>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm text-gray-800">{{ $post['body'] }}</p>
                                                <div class="mt-2 flex">
                                                    <span class="inline-flex items-center text-sm">
                                                        <button type="button" class="inline-flex space-x-2 text-gray-400 hover:text-gray-500">
                                                            <x-heroicon-o-chat-alt class="h-5 w-5" aria-hidden="true" />
                                                            <span class="font-medium text-gray-900">{{ $post['comments'] }}</span>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="mt-6">
                                <a href="#" class="w-full block text-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    View all
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </aside>
    </div>
</div>

{{--<script>--}}
{{--    import {Menu, MenuButton, MenuItem, MenuItems, Popover, PopoverButton, PopoverPanel} from '@headlessui/vue'--}}
{{--    import {ChatAltIcon, CodeIcon, DotsVerticalIcon, EyeIcon, FlagIcon, PlusSmIcon, SearchIcon, ShareIcon, StarIcon, ThumbUpIcon,} from '@heroicons/vue/solid'--}}
{{--    import {BellIcon, FireIcon, HomeIcon, MenuIcon, TrendingUpIcon, UserGroupIcon, XIcon} from '@heroicons/vue/outline'--}}
{{--    import SocialAppLayout from '../Layouts/SocialAppLayout'--}}
{{--    import AppLayout from "@/Layouts/AppLayout";--}}
{{--    import {defineComponent} from 'vue'--}}
{{--    import NewPostBox from "../Components/NewPostBox";--}}
{{--    import PostListItem from "../Components/PostListItem";--}}


{{--    // const user = {--}}
{{--    //     name: 'Chelsea Hagon',--}}
{{--    //     email: 'chelseahagon@example.com',--}}
{{--    //     imageUrl:--}}
{{--    //         'https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',--}}
{{--    // }--}}
{{--    const navigation = [--}}
{{--        {label: 'Home', name: 'home', icon: HomeIcon, current: true},--}}
{{--        {label: 'Explore', name: 'explore', icon: TrendingUpIcon, current: false},--}}
{{--        {label: 'Projects', name: 'projects', icon: FireIcon, current: false},--}}
{{--        {label: 'My Profile', name: 'profile', icon: UserGroupIcon, current: false},--}}
{{--    ]--}}
{{--    const userNavigation = [--}}
{{--        {name: 'Your Profile', href: '#'},--}}
{{--        {name: 'Settings', href: '#'},--}}
{{--        {name: 'Sign out', href: '#'},--}}
{{--    ]--}}
{{--    const communities = [--}}
{{--        {name: 'Movies', href: '#'},--}}
{{--        {name: 'Food', href: '#'},--}}
{{--        {name: 'Sports', href: '#'},--}}
{{--        {name: 'Animals', href: '#'},--}}
{{--        {name: 'Science', href: '#'},--}}
{{--        {name: 'Dinosaurs', href: '#'},--}}
{{--        {name: 'Talents', href: '#'},--}}
{{--        {name: 'Gaming', href: '#'},--}}
{{--    ]--}}
{{--    const tabs = [--}}
{{--        {name: 'Recent', href: '#', current: true},--}}
{{--        {name: 'Most Liked', href: '#', current: false},--}}
{{--        {name: 'Most Answers', href: '#', current: false},--}}
{{--    ]--}}
{{--    const questions = [--}}
{{--        {--}}
{{--            id: '81614',--}}
{{--            likes: '29',--}}
{{--            replies: '11',--}}
{{--            views: '2.7k',--}}
{{--            author: {--}}
{{--                name: 'Dries Vincent',--}}
{{--                imageUrl:--}}
{{--                    'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',--}}
{{--                href: '#',--}}
{{--            },--}}
{{--            date: 'December 9 at 11:43 AM',--}}
{{--            datetime: '2020-12-09T11:43:00',--}}
{{--            href: '#',--}}
{{--            title: 'What would you have done differently if you ran Jurassic Park?',--}}
{{--            body: `--}}
{{--      <p>Jurassic Park was an incredible idea and a magnificent feat of engineering, but poor protocols and a disregard for human safety killed what could have otherwise been one of the best businesses of our generation.</p>--}}
{{--      <p>Ultimately, I think that if you wanted to run the park successfully and keep visitors safe, the most important thing to prioritize would be&hellip;</p>--}}
{{--    `,--}}
{{--        },--}}
{{--        {--}}
{{--            id: '81614',--}}
{{--            likes: '29',--}}
{{--            replies: '11',--}}
{{--            views: '2.7k',--}}
{{--            author: {--}}
{{--                name: 'Dries Vincent',--}}
{{--                imageUrl:--}}
{{--                    'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',--}}
{{--                href: '#',--}}
{{--            },--}}
{{--            date: 'December 9 at 11:43 AM',--}}
{{--            datetime: '2020-12-09T11:43:00',--}}
{{--            href: '#',--}}
{{--            title: 'What would you have done differently if you ran Jurassic Park?',--}}
{{--            body: `--}}
{{--      <p>Jurassic Park was an incredible idea and a magnificent feat of engineering, but poor protocols and a disregard for human safety killed what could have otherwise been one of the best businesses of our generation.</p>--}}
{{--      <p>Ultimately, I think that if you wanted to run the park successfully and keep visitors safe, the most important thing to prioritize would be&hellip;</p>--}}
{{--    `,--}}
{{--        },--}}
{{--        {--}}
{{--            id: '81614',--}}
{{--            likes: '29',--}}
{{--            replies: '11',--}}
{{--            views: '2.7k',--}}
{{--            author: {--}}
{{--                name: 'Dries Vincent',--}}
{{--                imageUrl:--}}
{{--                    'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',--}}
{{--                href: '#',--}}
{{--            },--}}
{{--            date: 'December 9 at 11:43 AM',--}}
{{--            datetime: '2020-12-09T11:43:00',--}}
{{--            href: '#',--}}
{{--            title: 'What would you have done differently if you ran Jurassic Park?',--}}
{{--            body: `--}}
{{--      <p>Jurassic Park was an incredible idea and a magnificent feat of engineering, but poor protocols and a disregard for human safety killed what could have otherwise been one of the best businesses of our generation.</p>--}}
{{--      <p>Ultimately, I think that if you wanted to run the park successfully and keep visitors safe, the most important thing to prioritize would be&hellip;</p>--}}
{{--    `,--}}
{{--        },--}}
{{--        {--}}
{{--            id: '81614',--}}
{{--            likes: '29',--}}
{{--            replies: '11',--}}
{{--            views: '2.7k',--}}
{{--            author: {--}}
{{--                name: 'Dries Vincent',--}}
{{--                imageUrl:--}}
{{--                    'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',--}}
{{--                href: '#',--}}
{{--            },--}}
{{--            date: 'December 9 at 11:43 AM',--}}
{{--            datetime: '2020-12-09T11:43:00',--}}
{{--            href: '#',--}}
{{--            title: 'What would you have done differently if you ran Jurassic Park?',--}}
{{--            body: `--}}
{{--      <p>Jurassic Park was an incredible idea and a magnificent feat of engineering, but poor protocols and a disregard for human safety killed what could have otherwise been one of the best businesses of our generation.</p>--}}
{{--      <p>Ultimately, I think that if you wanted to run the park successfully and keep visitors safe, the most important thing to prioritize would be&hellip;</p>--}}
{{--    `,--}}
{{--        },--}}
{{--    ]--}}
{{--    const whoToFollow = [--}}
{{--        {--}}
{{--            name: 'Leonard Krasner',--}}
{{--            profile: {--}}
{{--                handle: 'leonardkrasner',--}}
{{--            },--}}
{{--            href: '#',--}}
{{--            imageUrl:--}}
{{--                'https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',--}}
{{--        },--}}
{{--        {--}}
{{--            name: 'Leonard Krasner',--}}
{{--            profile: {--}}
{{--                handle: 'leonardkrasner',--}}
{{--            },--}}
{{--            href: '#',--}}
{{--            imageUrl:--}}
{{--                'https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',--}}
{{--        },--}}
{{--        {--}}
{{--            name: 'Leonard Krasner',--}}
{{--            profile: {--}}
{{--                handle: 'leonardkrasner',--}}
{{--            },--}}
{{--            href: '#',--}}
{{--            imageUrl:--}}
{{--                'https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',--}}
{{--        },--}}
{{--    ]--}}
{{--    const trendingPosts = [--}}
{{--        {--}}
{{--            id: 1,--}}
{{--            user: {--}}
{{--                name: 'Floyd Miles',--}}
{{--                imageUrl:--}}
{{--                    'https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',--}}
{{--            },--}}
{{--            body: 'What books do you have on your bookshelf just to look smarter than you actually are?',--}}
{{--            comments: 291,--}}
{{--        },--}}
{{--        {--}}
{{--            id: 1,--}}
{{--            user: {--}}
{{--                name: 'Floyd Miles',--}}
{{--                imageUrl:--}}
{{--                    'https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',--}}
{{--            },--}}
{{--            body: 'What books do you have on your bookshelf just to look smarter than you actually are?',--}}
{{--            comments: 291,--}}
{{--        },--}}
{{--        {--}}
{{--            id: 1,--}}
{{--            user: {--}}
{{--                name: 'Floyd Miles',--}}
{{--                imageUrl:--}}
{{--                    'https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',--}}
{{--            },--}}
{{--            body: 'What books do you have on your bookshelf just to look smarter than you actually are?',--}}
{{--            comments: 291,--}}
{{--        },--}}
{{--    ]--}}

{{--    export default defineComponent({--}}
{{--        name: 'Social Home',--}}
{{--        layout: [AppLayout, SocialAppLayout],--}}
{{--        props: {--}}
{{--            user: Object--}}
{{--        },--}}
{{--        components: {--}}
{{--            PostListItem,--}}
{{--            NewPostBox,--}}
{{--            Menu,--}}
{{--            MenuButton,--}}
{{--            MenuItem,--}}
{{--            MenuItems,--}}
{{--            Popover,--}}
{{--            PopoverButton,--}}
{{--            PopoverPanel,--}}
{{--            BellIcon,--}}
{{--            ChatAltIcon,--}}
{{--            CodeIcon,--}}
{{--            DotsVerticalIcon,--}}
{{--            EyeIcon,--}}
{{--            FlagIcon,--}}
{{--            MenuIcon,--}}
{{--            PlusSmIcon,--}}
{{--            SearchIcon,--}}
{{--            ShareIcon,--}}
{{--            StarIcon,--}}
{{--            ThumbUpIcon,--}}
{{--            XIcon,--}}
{{--        },--}}
{{--        setup() {--}}
{{--            return {--}}
{{--                navigation,--}}
{{--                userNavigation,--}}
{{--                communities,--}}
{{--                tabs,--}}
{{--                questions,--}}
{{--                whoToFollow,--}}
{{--                trendingPosts,--}}
{{--            }--}}
{{--        },--}}
{{--    })--}}
{{--</script>--}}
