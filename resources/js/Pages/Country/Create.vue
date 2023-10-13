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
    continents: Object,
});
const form = useForm({
    name: '',
    slug: '',
    continent_id: '',
    description: '',
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
    <AppLayout title="Country Create">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Country Create
            </h2>
        </template>

        <div>
            <form @submit.prevent="form.post(route('countries.store'), { onSuccess: () => form.reset() })">

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
                    <InputLabel for="continent_id" value="Continent" />
                    <select
                        v-model="form.continent_id"
                        class="w-full border border-gray-200 rounded"
                        required
                        autocomplete="continent_id"
                        >
                        <option value="">--Select--</option>
                        <option v-for="continent in props.continents" :value=continent.id>{{ continent.name }}</option>
                    </select>
                    <InputError :message="form.errors.continent_id" class="mt-2" />
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
