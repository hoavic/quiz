<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

defineProps({
    sessions: Array,
    list_terms: Array,
    taxonomies: Object
});
</script>

<template>
    <AppLayout title="Taxonomy Index">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Taxonomy Index
            </h2>
            <div class="flex justify-between">
                <Link :href="route('taxonomies.create')" class="py-2 px-4 bg-gray-200 rounded-lg">Create</Link>
                <Dropdown align="right" width="48">
                    <template #trigger>
                        <button class="py-2 px-4 bg-gray-200 rounded-lg border-2 border-transparent focus:outline-none focus:border-gray-300 transition">
                            More
                        </button>
                    </template>

                    <template #content>
                        <!-- Account Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            Choose one
                        </div>

                        <template v-for="term in list_terms">
                            <DropdownLink :href="route('taxonomies.create') + '?term=' + term.taxonomy">
                                {{ term.singularName }}
                            </DropdownLink>
                        </template>
                    </template>
                </Dropdown>
            </div>

        </template>

        <div class="my-6 flex gap-4">
            <div class="inline-block p-2 bg-gray-200 rounded-lg" v-for="term in list_terms">{{ term.taxonomy }}</div>
        </div>

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
                <template v-for="taxonomy in taxonomies">
                    <tr>
                        <td class="text-left">#</td>
                        <td class="text-left"><a :href="'/taxonomies/' + taxonomy.id + '/edit'">{{ taxonomy.name }}</a></td>
                        <td>{{ taxonomy.slug }}</td>
                        <td>{{ taxonomy.description }}</td>
                    </tr>
                </template>
            </tbody>
        </table>
    </AppLayout>
</template>
