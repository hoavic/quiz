<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import moment from 'moment';


defineProps({
    sessions: Array,
    quizzes: Object
});

const formatDate = (date) => {
    return moment(date).format('d-MM-Y');
}

</script>

<template>
    <AppLayout title="Quiz Index">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Quiz Index
            </h2>
            <Link :href="route('quizzes.create')">Create</Link>
        </template>

        <div class="max-w-full overflow-x-auto">
            <table class="w-full text-right text-sm">
                <thead class="bg-gray-200 border-b-4 border-gray-100">
                    <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">Title</th>
                        <th>Type</th>
                        <th>Is Published</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <template v-for="quiz in quizzes">
                        <tr class="group align-top border-b-4 border-gray-100">
                            <td class="text-lef">
                                <input type="checkbox" value="" class="rounded" disabled/>
                            </td>
                            <td class="text-left">
                                <a :href="route('quizzes.edit', quiz.id)">
                                    <span class="block text-lg text-blue-900 font-medium">{{ quiz.title }}</span>
                                    <div class="mt-1 lg:invisible lg:group-hover:visible flex gap-4">
                                        <a :href="route('quizzes.show', quiz.id)" class="text-green-800">Xem</a>
                                        <a :href="route('quizzes.edit', quiz.id)" class="text-blue-800">Sửa</a>
                                        <a :href="route('quizzes.destroy', quiz.id)" class="text-rose-800">Xóa</a>
                                    </div>
                                </a>
                            </td>
                            <td class="">{{ quiz.type }}</td>
                            <td class="">{{ quiz.published }}</td>
                            <td class=" text-gray-600">{{ formatDate(quiz.created_at) }}</td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

    </AppLayout>
</template>
