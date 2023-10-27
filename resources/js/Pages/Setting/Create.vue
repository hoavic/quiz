<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';
import CreateString from './CreateString.vue';
import CreateList from './CreateList.vue';

defineProps({
    sessions: Array,
});

const form = useForm({
    key: '',
    value: '',
    group: '',
});

const acceptableTypes = ref([
    {key: 'string', label: 'String'},
    {key: 'list', label: 'List'},
    {key: 'object', label: 'Object'},
]);

const type = ref('list');

</script>

<template>
    <AppLayout title="Setting Create">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Setting Create
            </h2>
        </template>

        <div>
            <form @submit.prevent="form.post(route('settings.store'), { onSuccess: () => form.reset() })">

                <div class="my-6">
                    <InputLabel for="key" value="Key" />
                    <TextInput
                        id="key"
                        v-model="form.key"
                        type="text"
                        class="mt-1 block w-full"
                        required
                        autofocus
                        autocomplete="key"
                    />
                    <InputError class="mt-2" :message="form.errors.key" />
                </div>

                <div class="my-6">
                    <InputLabel for="type" value="Type" />
                    <select
                        id="type"
                        v-model="type"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >
                        <option v-for="acceptableType in acceptableTypes" :value="acceptableType.key">{{ acceptableType.label }}</option>
                    </select>
                </div>

                <div class="my-6">
                    <CreateString v-model="form.value" v-if="type === 'string'" />
                    <CreateList v-model="form.value" v-if="type === 'list'" />
                </div>


                <div class="my-6">
                    <input
                        id="group"
                        v-model="form.group"
                        type="text"
                        class="mt-1 block w-full bg-gray-100 border border-gray-200 rounded"
                        required
                        autofocus
                        autocomplete="group"
                    />
                    <InputError class="mt-2" :message="form.errors.group" />
                </div>

                <PrimaryButton class="mt-4">Create</PrimaryButton>
            </form>
        </div>
    </AppLayout>
</template>
