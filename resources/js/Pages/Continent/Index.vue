<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
defineProps({
    sessions: Array,
    continents: Object
});
</script>

<template>
    <AppLayout title="Continent Index">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Continent Index
            </h2>
            <Link :href="route('continents.create')">Create</Link>
        </template>

        <table class="w-full text-right">
            <thead>
                <tr>
                    <th class="text-left">#</th>
                    <th class="text-left">Name</th>
                    <th>Slug</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <template v-for="continent in continents">
                    <tr>
                        <td class="text-left">#</td>
                        <td class="text-left"><a :href="'/continents/' + continent.id + '/edit'">{{ continent.name }}</a></td>
                        <td>{{ continent.slug }}</td>
                        <td>{{ continent.description }}</td>
                    </tr>
                </template>
            </tbody>
        </table>
    </AppLayout>
</template>
