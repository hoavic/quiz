<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    sessions: Array,
});

</script>

<template>
    <AppLayout title="Quiz Create">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Quiz Create
            </h2>
        </template>

        <div>
            <h2 class="text-center">Select a Type of Quiz:</h2>
            <ul class="my-6 grid grid-cols-2 gap-4 list-none">
                <li><a :href="route('quizzes.create') + '/?type=basic'" class="block py-2 px-3 bg-blue-800 text-white text-center rounded-full">Basic</a></li>
                <li><a :href="route('quizzes.create') + '/?type=show-a-score'" class="block py-2 px-3 bg-blue-800 text-white text-center rounded-full">Show a Score</a></li>
                <li><a :href="route('quizzes.create') + '/?type=poll-vote'" class="block py-2 px-3 bg-blue-800 text-white text-center rounded-full">Poll/Vote</a></li>
                <li><a :href="route('quizzes.create') + '/?type=product-service'" class="block py-2 px-3 bg-blue-800 text-white text-center rounded-full">Product/Service</a></li>
            </ul>
        </div>
    </AppLayout>
</template>
