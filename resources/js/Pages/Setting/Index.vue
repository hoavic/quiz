<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
defineProps({
    sessions: Array,
    settings: Object
});
</script>

<template>
    <AppLayout title="Setting Index">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Setting Index
            </h2>
            <Link :href="route('settings.create')">Create</Link>
        </template>

        <table class="w-full text-right">
            <thead>
                <tr>
                    <th class="text-left">#</th>
                    <th class="text-left">Key</th>
                    <th>Value</th>
                    <th>Group</th>
                </tr>
            </thead>
            <tbody>
                <template v-for="setting in settings">
                    <tr>
                        <td class="text-left">#</td>
                        <td class="text-left"><a :href="'/settings/' + setting.id + '/edit'">{{ setting.key }}</a></td>
                        <td>{{ setting.value }}</td>
                        <td>{{ setting.group }}</td>
                    </tr>
                </template>
            </tbody>
        </table>
    </AppLayout>
</template>
