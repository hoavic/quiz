<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import slugify from 'slugify';

const props = defineProps({
    sessions: Array,
    term_key: String,
    list_terms: Array,
});
const form = useForm({
    name: '',
    slug: '',
    description: '',
    term_key: props.term_key,
});

const autoSlug = () => {
    if(form.name != '') {
        form.slug = slugify(form.name, {
            replacement: '-',  // replace spaces with replacement character, defaults to `-`
            remove: undefined, // remove characters that match regex, defaults to `undefined`
            lower: true,      // convert to lower case, defaults to `false`
            strict: true,     // strip special characters except replacement, defaults to `false`
            locale: 'vi',      // language code of the locale to use
            trim: true
        });
    } else {
        form.slug = '';
    }
};

</script>

<template>
    <AppLayout title="Taxonomy Create">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Taxonomy Create
            </h2>
        </template>

        <div>
            <form @submit.prevent="form.post(route('taxonomies.store'), { onSuccess: () => form.reset() })">

                <div class="my-6">
                    <InputLabel for="name" value="Name" />
                    <TextInput
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="mt-1 block w-full"
                        required
                        autofocus
                        autocomplete="name"
                        @input="autoSlug"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="my-6">
                    <input
                        id="slug"
                        v-model="form.slug"
                        type="text"
                        class="mt-1 block w-full bg-gray-100 border border-gray-200 rounded"
                        required
                        autofocus
                        autocomplete="slug"
                    />
                    <InputError class="mt-2" :message="form.errors.slug" />
                </div>

                <div class="my-6">
                    <InputLabel for="term_key" value="Type" />
                    <select
                        id="term_key"
                        v-model="form.term_key"
                        class="block w-full bg-gray-100 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        disabled
                        >
                        <option v-for="term in list_terms" :value="term.taxonomy">{{ term.singularName }}</option>
                    </select>
                    <InputError :message="form.errors.description" class="mt-2" />
                </div>

                <div class="my-6">
                    <InputLabel for="description" value="Description" />
                    <textarea
                        id="description"
                        v-model="form.description"
                        placeholder="Description..."
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    ></textarea>
                    <InputError :message="form.errors.description" class="mt-2" />
                </div>

                <PrimaryButton class="mt-4">Create</PrimaryButton>
            </form>
        </div>
    </AppLayout>
</template>
