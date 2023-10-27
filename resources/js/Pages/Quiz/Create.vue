<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import VueDatePickerProps from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import slugify from 'slugify';

defineProps({
    sessions: Array,
    quiz: Object,
});
const form = useForm({
    title: '',
    slug: '',
    summary: '',
    type: 0,
    published: 0,
    published_at: null,
    start_at: '',
    end_at: '',
    content: '',
});

const autoSlug = () => {
    if(form.title != '') {
        form.slug = slugify(form.title);
    } else {
        form.slug = '';
    }
};

</script>

<template>
    <AppLayout title="Quiz Create">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Quiz Create
            </h2>
        </template>

        <div>
            <form @submit.prevent="form.post(route('quizzes.store'), { onSuccess: () => form.reset() })">
                <div class="my-6">
                    <InputLabel for="title" value="Title" />
                    <TextInput
                        id="title"
                        v-model="form.title"
                        type="text"
                        class="mt-1 block w-full"
                        required
                        autofocus
                        autocomplete="title"
                        @input="autoSlug"
                    />
                    <InputError class="mt-2" :message="form.errors.title" />
                </div>

                <textarea
                    v-model="form.summary"
                    placeholder="Summary..."
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                ></textarea>

                <div class="grid grid-cols-2 gap-4">
                    <div class="my-6">
                        <InputLabel for="type" value="Type" />
                        <select v-model="form.type" name="type" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="0">Default</option>
                            <option value="1">Custom</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.type" />
                    </div>

                    <div class="my-6">
                        <InputLabel for="published" value="Published" />
                        <select v-model="form.published" name="published" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.type" />
                    </div>
                </div>

                <div class="">
                    <h3 class="font-bold">Selected: {{ form.type }}</h3>

                    <div class="p-4 bg-white border border-gray-300 rounded-lg">


                    </div>

                </div>

                <div class="grid md:grid-cols-2 md:gap-4">
                    <div class="my-6">
                        <InputLabel for="start_at" value="Start At" />
                        <VueDatePickerProps v-model="form.start_at" placeholder="Choosing start date ..." text-input :min-date="new Date()"></VueDatePickerProps>
                        <InputError class="mt-2" :message="form.errors.start_at" />
                    </div>

                    <div class="my-6">
                        <InputLabel for="end_at" value="End At" />
                        <VueDatePickerProps v-model="form.end_at"  placeholder="Choosing end date ..." text-input :min-date="new Date()"></VueDatePickerProps>
                        <InputError class="mt-2" :message="form.errors.end_at" />
                    </div>
                </div>

                <textarea
                    v-model="form.content"
                    placeholder="What's on your mind?"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                ></textarea>
                <InputError :message="form.errors.message" class="mt-2" />
                <PrimaryButton class="mt-4">Save</PrimaryButton>
            </form>
        </div>
    </AppLayout>
</template>
