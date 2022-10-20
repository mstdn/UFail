<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Banner from '@/Components/Banner.vue';
import SideLink from '../Pages/Shared/SideLink.vue';
import Compose from '../Pages/Shared/Compose.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    Inertia.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
    <div>

        <Head :title="title" />

        <Banner />

        <div class="drawer">
            <input id="drawer" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content flex flex-col">
                <!-- Navbar -->
                <div class="sticky top-0 z-50 w-full navbar bg-black border-gray-900 border-b-[1px]">
                    <div class="flex-none lg:hidden">
                        <label for="drawer" class="btn btn-square btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                class="inline-block w-6 h-6 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </label>
                    </div>
                    <div class="flex-1 px-2 mx-2">
                        <Link href="/" class="btn btn-ghost">{{ $page.props.appName }}</Link>
                    </div>
                    <div class="flex-none hidden lg:block">
                        <ul class="menu menu-horizontal">
                            <!-- Navbar menu content here -->
                            <li>
                                <Link :href="route('index')">
                                Home
                                </Link>
                            </li>
                            <li>
                                <Link :href="route('categories')">
                                Explore
                                </Link>
                            </li>
                        </ul>
                    </div>
                    <div class="flex-none gap-2 pl-2">
                        <Compose v-if="$page.props.auth.user !== null" />
                        <div v-if="$page.props.auth.user !== null" class="dropdown dropdown-end">
                            <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                                <div class="w-10 rounded-full">
                                    <img :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                                </div>
                            </label>
                            <ul tabindex="0"
                                class="mt-3 p-2 shadow menu menu-compact dropdown-content bg-base-100 rounded-box w-52">
                                <li>
                                    <Link :href="route('profile.show')" class="justify-between">
                                    Profile
                                    <span class="badge">New</span>
                                    </Link>
                                </li>
                                <li>
                                    <Link v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                                    API
                                    </Link>
                                </li>
                                <li>
                                    <Link method="post" :href="route('logout')">Logout</Link>
                                </li>
                            </ul>
                        </div>
                        <Link href="/register" v-if="$page.props.auth.user === null" class="btn btn-primary">Signup
                        </Link>
                    </div>

                </div>
                <!-- Page content here -->
                <div class="container mx-auto">
                    <div class="flex flex-row justify-center">
                        <!-- Left -->
                        <div class="w-68 xs:w-88 xl:w-275 h-full">
                            <div
                                class="flex flex-col h-screen xl:pr-3 fixed w-68 xs:w-88 xl:w-275 border-base-300 border-r">
                                <!-- Nav logged in -->
                                <nav v-if="$page.props.auth.user !== null" class="mt-8">
                                    <SideLink :href="route('index')" :active="$page.component === 'Feed/Index'">
                                        <svg fill="currentColor" viewBox="0 0 24 24" class="h-6 w-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M22.58 7.35L12.475 1.897c-.297-.16-.654-.16-.95 0L1.425 7.35c-.486.264-.667.87-.405 1.356.18.335.525.525.88.525.16 0 .324-.038.475-.12l.734-.396 1.59 11.25c.216 1.214 1.31 2.062 2.66 2.062h9.282c1.35 0 2.444-.848 2.662-2.088l1.588-11.225.737.398c.485.263 1.092.082 1.354-.404.263-.486.08-1.093-.404-1.355zM12 15.435c-1.795 0-3.25-1.455-3.25-3.25s1.455-3.25 3.25-3.25 3.25 1.455 3.25 3.25-1.455 3.25-3.25 3.25z">
                                            </path>
                                        </svg>
                                        <span class="hidden xl:block ml-4 font-bold text-md">
                                            Browse
                                        </span>
                                    </SideLink>
                                    <SideLink :href="route('categories')" :active="$page.component === 'Welcome'">
                                        <svg fill="currentColor" viewBox="0 0 24 24" class="h-6 w-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 7.337h-3.93l.372-4.272c.036-.412-.27-.775-.682-.812-.417-.03-.776.27-.812.683l-.383 4.4h-6.32l.37-4.27c.037-.413-.27-.776-.68-.813-.42-.03-.777.27-.813.683l-.382 4.4H3.782c-.414 0-.75.337-.75.75s.336.75.75.75H7.61l-.55 6.327H3c-.414 0-.75.336-.75.75s.336.75.75.75h3.93l-.372 4.272c-.036.412.27.775.682.812l.066.003c.385 0 .712-.295.746-.686l.383-4.4h6.32l-.37 4.27c-.036.413.27.776.682.813l.066.003c.385 0 .712-.295.746-.686l.382-4.4h3.957c.413 0 .75-.337.75-.75s-.337-.75-.75-.75H16.39l.55-6.327H21c.414 0 .75-.336.75-.75s-.336-.75-.75-.75zm-6.115 7.826h-6.32l.55-6.326h6.32l-.55 6.326z">
                                            </path>
                                        </svg>
                                        <span class="hidden xl:block ml-4 font-bold text-md">
                                            Explore
                                        </span>
                                    </SideLink>
                                    <SideLink href="/community" :active="$page.component === 'Welcome'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        </svg>
                                        <span class="hidden xl:block ml-4 font-bold text-md">
                                            Community
                                        </span>
                                    </SideLink>
                                    <SideLink href="/notifications" :active="$page.component === 'Welcome'">
                                        <svg fill="currentColor" viewBox="0 0 24 24" class="h-6 w-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21.697 16.468c-.02-.016-2.14-1.64-2.103-6.03.02-2.532-.812-4.782-2.347-6.335C15.872 2.71 14.01 1.94 12.005 1.93h-.013c-2.004.01-3.866.78-5.242 2.174-1.534 1.553-2.368 3.802-2.346 6.334.037 4.33-2.02 5.967-2.102 6.03-.26.193-.366.53-.265.838.102.308.39.515.712.515h4.92c.102 2.31 1.997 4.16 4.33 4.16s4.226-1.85 4.327-4.16h4.922c.322 0 .61-.206.71-.514.103-.307-.003-.645-.263-.838zM12 20.478c-1.505 0-2.73-1.177-2.828-2.658h5.656c-.1 1.48-1.323 2.66-2.828 2.66zM4.38 16.32c.74-1.132 1.548-3.028 1.524-5.896-.018-2.16.644-3.982 1.913-5.267C8.91 4.05 10.397 3.437 12 3.43c1.603.008 3.087.62 4.18 1.728 1.27 1.285 1.933 3.106 1.915 5.267-.024 2.868.785 4.765 1.525 5.896H4.38z">
                                            </path>
                                        </svg>
                                        <span class="hidden xl:block ml-4 font-bold text-md">
                                            Notifications
                                        </span>
                                    </SideLink>
                                    <!-- <SideLink :href="route('user-profile', {id: $page.props.user.username})"
                                        :active="$page.url === 'Users/Show'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5.52 19c.64-2.2 1.84-3 3.22-3h6.52c1.38 0 2.58.8 3.22 3" />
                                            <circle cx="12" cy="10" r="3" />
                                            <circle cx="12" cy="12" r="10" />
                                        </svg>
                                        <span class="hidden xl:block ml-4 font-bold text-md">
                                            Profile
                                        </span>
                                    </SideLink> -->
                                    <SideLink href="/user/profile" :active="$page.url === '/user/profile'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="3"></circle>
                                            <path
                                                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                            </path>
                                        </svg>
                                        <span class="hidden xl:block ml-4 font-bold text-md">
                                            Settings
                                        </span>
                                    </SideLink>

                                    <!-- <SideLink as="button" method="post" :href="route('logout')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M16 17l5-5-5-5M19.8 12H9M10 3H4v18h6" />
                                        </svg>
                                        <span class="hidden xl:block ml-4 font-bold text-md">
                                            Logout
                                        </span>
                                    </SideLink> -->
                                </nav>
                                <!-- /Nav -->

                                <!-- Nav logged out -->
                                <nav v-if="$page.props.auth.user === null" class="mt-8">
                                    <SideLink href="/" :active="$page.component === 'Timeline/Public'">
                                        <svg fill="currentColor" viewBox="0 0 24 24" class="h-6 w-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M22.58 7.35L12.475 1.897c-.297-.16-.654-.16-.95 0L1.425 7.35c-.486.264-.667.87-.405 1.356.18.335.525.525.88.525.16 0 .324-.038.475-.12l.734-.396 1.59 11.25c.216 1.214 1.31 2.062 2.66 2.062h9.282c1.35 0 2.444-.848 2.662-2.088l1.588-11.225.737.398c.485.263 1.092.082 1.354-.404.263-.486.08-1.093-.404-1.355zM12 15.435c-1.795 0-3.25-1.455-3.25-3.25s1.455-3.25 3.25-3.25 3.25 1.455 3.25 3.25-1.455 3.25-3.25 3.25z">
                                            </path>
                                        </svg>
                                        <span class="hidden xl:block ml-4 font-bold text-md">
                                            Home
                                        </span>
                                    </SideLink>
                                    <SideLink href="/community" :active="$page.component === 'Users/Community'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        </svg>
                                        <span class="hidden xl:block ml-4 font-bold text-md">
                                            Community
                                        </span>
                                    </SideLink>
                                    <SideLink href="/login" :active="$page.component === 'Auth/Login'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path
                                                d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3" />
                                        </svg>
                                        <span class="hidden xl:block ml-4 font-bold text-md">
                                            Login
                                        </span>
                                    </SideLink>
                                    <SideLink href="/register" :active="$page.component === 'Auth/Register'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="8.5" cy="7" r="4"></circle>
                                            <line x1="20" y1="8" x2="20" y2="14"></line>
                                            <line x1="23" y1="11" x2="17" y2="11"></line>
                                        </svg>
                                        <span class="hidden xl:block ml-4 font-bold text-md">
                                            Register
                                        </span>
                                    </SideLink>
                                </nav>
                                <!-- /Nav -->

                                <ul class="menu w-full hidden lg:block">
                                    <div class="divider"></div>
                                    <li v-for="category in $page.props.categories" :key="category.id">
                                        <Link :href="route('category', { id: category.slug })">
                                        {{ category.name }}
                                        </Link>
                                    </li>
                                </ul>

                            </div>
                        </div>

                        <!-- Middle -->
                        <div class="w-full sm:w-600 h-screen">
                            <header v-if="$slots.header">
                                <h3 class="text-2xl font-extrabold mt-6 ml-4">
                                    <span
                                        class="text-transparent bg-clip-text bg-gradient-to-r to-red-500 from-red-800">
                                        <slot name="header" />
                                    </span>
                                </h3>
                            </header>
                            <!-- <FlashMessage /> -->
                            <slot />
                        </div>
                        <!-- Right -->
                        <!-- <div class="hidden md:block w-290 lg:w-350 h-screen">
                            <div class="flex flex-col fixed overflow-y-auto w-290 lg:w-350 h-screen">

                                <div class="bg-white dark:bg-gray-800 rounded-2xl m-2 mt-8">
                                    <h1
                                        class="text-gray-900 dark:text-white text-md font-bold p-3 border-b border-gray-200 dark:border-gray-900">
                                        Popular
                                    </h1>

                                    <div
                                        class="text-red-400 text-sm font-normal p-3 border-b border-gray-200 dark:border-gray-900 hover:bg-gray-100 dark:hover:bg-gray-900 cursor-pointer transition duration-350 ease-in-out">
                                        <h2 class="font-bold text-md text-gray-800 dark:text-white">
                                            #soon
                                        </h2>
                                        <p class="text-xs text-gray-400">194 Posts</p>
                                    </div>

                                    <div
                                        class="text-red-400 text-sm font-normal p-3 border-b border-gray-200 dark:border-gray-900 hover:bg-gray-100 dark:hover:bg-gray-900 cursor-pointer transition duration-350 ease-in-out">
                                        <h2 class="font-bold text-md text-gray-800 dark:text-white">
                                            #soon
                                        </h2>
                                        <p class="text-xs text-gray-400">45 Posts</p>
                                    </div>

                                    <div
                                        class="text-red-400 text-sm font-normal p-3 border-b border-gray-200 dark:border-gray-900 hover:bg-gray-100 dark:hover:bg-gray-900 cursor-pointer transition duration-350 ease-in-out">
                                        <h2 class="font-bold text-md text-gray-800 dark:text-white">
                                            #soon
                                        </h2>
                                        <p class="text-xs text-gray-400">45 Posts</p>
                                    </div>

                                    <div
                                        class="text-red-400 text-sm font-normal hover:underline p-3 dark:hover:bg-dim-300 cursor-pointer transition duration-350 ease-in-out">
                                        Show more
                                    </div>
                                </div>

                                <div class="bg-white dark:bg-gray-800 rounded-2xl m-2">
                                    <h1
                                        class="text-gray-900 dark:text-white text-md font-bold p-3 border-b border-gray-200 dark:border-gray-900">
                                        See also
                                    </h1>

                                    <div
                                        class="text-red-400 text-sm font-normal p-3 border-b border-gray-200 dark:border-gray-900 hover:bg-gray-100 dark:hover:bg-gray-900 cursor-pointer transition duration-350 ease-in-out">
                                        <div class="flex flex-row justify-between p-2">
                                            <div class="flex flex-row">
                                                <img class="w-10 h-10 rounded-full"
                                                    src="https://media.mstdn.social/accounts/avatars/000/005/168/original/3d4b017a1edb6237.png"
                                                    alt="" />
                                                <div class="flex flex-col ml-2">
                                                    <h1 class="text-gray-900 dark:text-white font-bold text-sm">
                                                        stux
                                                    </h1>
                                                    <p class="text-gray-400 text-sm">@stux</p>
                                                </div>
                                            </div>
                                            <div class="">
                                                <div class="flex items-center h-full text-gray-800 dark:text-white">
                                                    <a href="/@stux"
                                                        class="text-xs font-bold text-red-400 px-4 py-1 rounded-full border-2 border-red-400">Follow</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div
                                        class="text-red-400 text-sm font-normal p-3 hover:underline dark:hover:bg-dim-300 cursor-pointer transition duration-350 ease-in-out">
                                        Show more
                                    </div>
                                </div>

                                <footer>
                                    <ul class="text-xs text-gray-500 dark:text-gray-100 my-4 mx-2">
                                        <li class="inline-block mx-2">
                                            <InertiaLink href="/about" class="hover:underline">About</InertiaLink>
                                        </li>
                                        <li class="inline-block mx-2">
                                            <InertiaLink href="/terms-of-service" class="hover:underline">Terms
                                            </InertiaLink>
                                        </li>
                                        <li class="inline-block mx-2">
                                            <InertiaLink href="/privacy-policy" class="hover:underline">Privacy
                                            </InertiaLink>
                                        </li>
                                        <li class="inline-block mx-2">
                                            <a class="hover:underline" target="_blank"
                                                href="https://github.com/Goldfish-Social/Goldfish">Source</a>
                                        </li>
                                        <li class="inline-block mx-2">© 2022. <a
                                                href="https://github.com/Goldfish-Social/Goldfish"
                                                target="_blank">Goldfish</a></li>
                                    </ul>
                                </footer>


                            </div>
                        </div> -->
                        <!-- /Right -->
                    </div>
                </div>

            </div>
            <div class="drawer-side">
                <label for="drawer" class="drawer-overlay"></label>
                <ul class="menu p-4 overflow-y-auto w-80 bg-base-100">
                    <!-- Sidebar content here -->
                    <li>
                        <Link :href="route('index')">Home</Link>
                    </li>
                    <li>
                        <Link :href="route('categories')">Explore</Link>
                    </li>
                    <div class="divider"></div>
                    <li v-for="category in $page.props.categories" :key="category.id">
                        <Link :href="route('category', { id: category.slug })">
                        {{ category.name }}
                        </Link>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</template>
