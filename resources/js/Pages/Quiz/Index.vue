<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
defineProps({
    sessions: Array,
    quizzes: Object
});
</script>

<template>
    <AppLayout title="Quiz Index">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Quiz Index
            </h2>
            <Link :href="route('quizzes.create')">Create</Link>
        </template>

        <table class="w-full text-right">
            <thead>
                <tr>
                    <th class="text-left">#</th>
                    <th class="text-left">Title</th>
                    <th>Type</th>
                    <th>Is Published</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <template v-for="quiz in quizzes">
                    <tr>
                        <td class="text-left">#</td>
                        <td class="text-left"><a :href="'/quizzes/' + quiz.id + '/edit'">{{ quiz.title }}</a></td>
                        <td>{{ quiz.type }}</td>
                        <td>{{ quiz.published }}</td>
                        <td>{{ quiz.created_at }}</td>
                    </tr>
                </template>
            </tbody>
        </table>
    </AppLayout>
</template>
