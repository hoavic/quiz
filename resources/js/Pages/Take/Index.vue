<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
defineProps({
    sessions: Array,
    takes: Object
});
</script>

<template>
    <AppLayout title="Take Index">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Take Index
            </h2>
            <Link :href="route('takes.create')">Create</Link>
        </template>

        <div>
            <p>Take Index...</p>
        </div>
    </AppLayout>
</template>
