<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    sessions: Array,
    take: Object,
});
const form = useForm({

});
</script>

<template>
    <AppLayout title="Take Create">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Take Create
            </h2>
        </template>

        <div>
            <form @submit.prevent="form.post(route('takes.store'), { onSuccess: () => form.reset() })">
                <textarea
                    v-model="form.message"
                    placeholder="What's on your mind?"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                ></textarea>
                <InputError :message="form.errors.message" class="mt-2" />
                <PrimaryButton class="mt-4">Save</PrimaryButton>
            </form>
        </div>
    </AppLayout>
</template>
