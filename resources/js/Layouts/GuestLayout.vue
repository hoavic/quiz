<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const logout = () => {
    router.post(route('logout'));
};

</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-100">
            <header class=" sticky top-0 bg-white border-b border-gray-100 shadow">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                    <div class="flex items-center gap-4 h-16">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <Link :href="route('dashboard')">
                                <ApplicationMark class="block h-9 w-auto" />
                            </Link>
                        </div>

                        <div class="relative w-64 text-gray-600">
                            <form>
                                <input type="text" placeholder="Tìm kiếm..." class="w-full pl-4 pr-10 py-1 border border-gray-200 rounded-full" />
                                <button type="submit" class="absolute right-0 py-1 px-3 text-gray-400">
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <g>
                                            <path fill="none" d="M0 0h24v24H0z"></path>
                                            <path d="M18.031 16.617l4.283 4.282-1.415 1.415-4.282-4.283A8.96 8.96 0 0 1 11 20c-4.968 0-9-4.032-9-9s4.032-9 9-9 9 4.032 9 9a8.96 8.96 0 0 1-1.969 5.617zm-2.006-.742A6.977 6.977 0 0 0 18 11c0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7a6.977 6.977 0 0 0 4.875-1.975l.15-.15z"></path>
                                        </g>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <Transition name="fade">
                            <div v-if="showingNavigationDropdown" class="fixed top-0 bottom-0 left-0 right-0 bg-gray-900/10" @click.prevent="showingNavigationDropdown = false"></div>
                        </Transition>

                        <nav class="fixed left-0 top-0 w-[250px] min-h-screen overflow-y-auto -translate-x-[250px] transition-all bg-white text-gray-600 font-bold"
                            :class="showingNavigationDropdown ? 'translate-x-0' : 'lg:translate-x-0 lg:relative lg:w-full lg:min-h-0'">
                            <ul class="my-6 lg:my-0 flex-col lg:flex lg:flex-row items-center gap-4">
                                <li>
                                    <a href="#" class="inline-block py-2 px-4">Trang chủ</a>
                                </li>
                                <li>
                                    <a href="#" class="inline-block py-2 px-4">Quiz</a>
                                </li>
                            </ul>
                        </nav>

                        <button class="inline-flex lg:hidden items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out" @click="showingNavigationDropdown = ! showingNavigationDropdown">
                            <svg
                                class="h-6 w-6"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    :class="{'hidden': showingNavigationDropdown}"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{'hidden': ! showingNavigationDropdown}"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>

                </div>

            </header>

            <!-- Page Content -->
            <main>
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

                    <!-- Page Heading -->
                    <header v-if="$slots.header" class="">
                            <h1 class="mb-4 font-bold text-2xl"><slot name="header" /></h1>
                    </header>

                    <div class="site-content">
                        <slot />
                    </div>

                </div>

            </main>
        </div>
    </div>
</template>
