<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

import { ref } from 'vue';

const props = defineProps({
    sessions: Array,
    term: Object,
});

const form = useForm(props.term);

console.log(props.term);

var sample = {singularName: "Custom", pluralName: "Customs", taxonomy: "custom", isHierarchy: "true"};

const terms = ref(JSON.parse(props.term.value));

const addItem = () => {
    console.log(terms);
    terms.value.push(sample);
};

const removeItem = (index) => {
    terms.value.splice(index,1);
};

const syncTerm = () => {
    form.value = JSON.stringify(terms.value);
}

</script>

<template>
    <AppLayout title="Setting">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Term Setting
            </h2>
        </template>

        <div>

            <button type="button" @click.prevent="addItem" class="my-4 py-1 px-3 bg-gray-200 rounded-lg">add</button>
            <template v-for="(term, index) in terms">
                <div class="my-2 flex items-center gap-4">
                    <div class="my-2 flex items-center gap-2">
                        <label class="text-gray-600">Singular Name: </label>
                        <input
                            v-model="terms[index].singularName" type="text" :placeholder="'Name... ' + index"
                            @input="syncTerm"
                            :disabled="index < 2"
                            class="block w-full bg-white border-gray-300 disabled:bg-gray-100 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"/>
                    </div>
                    <div class="my-2 flex items-center gap-2">
                        <label class="text-gray-600">Plural Name: </label>
                        <input
                            v-model="terms[index].pluralName" type="text" :placeholder="'Name... ' + index"
                            @input="syncTerm"
                            :disabled="index < 2"
                            class="block w-full bg-white border-gray-300 disabled:bg-gray-100 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"/>
                    </div>
                    <div class="my-2 flex items-center gap-2">
                        <label class="text-gray-600">Taxonomy: </label>
                        <input
                            v-model="terms[index].taxonomy" type="text" :placeholder="'Tax... ' + index"
                            @input="syncTerm"
                            :disabled="index < 2"
                            class="block w-full bg-white border-gray-300 disabled:bg-gray-100 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"/>
                    </div>
                    <div class="my-2 flex items-center gap-2">
                        <div>isHierarchy: </div>
                        <div class="text-gray-600">
                            <input
                            v-model="terms[index].isHierarchy" type="radio" :placeholder="'Tax... ' + index" value="true"
                            @input="syncTerm"
                            :disabled="index < 2"
                            class="mr-2 disabled:bg-gray-100 roundec-full"/>
                            <label>true</label>
                        </div>

                        <div class="">
                            <input
                            v-model="terms[index].isHierarchy" type="radio" :placeholder="'Tax... ' + index" value="false"
                            @input="syncTerm"
                            :disabled="index < 2"
                            class="mr-2 disabled:bg-gray-100 roundec-full"/>
                            <label>false</label>
                        </div>
                    </div>
                    <button v-if="!(index < 2)" type="button" @click.prevent="removeItem(index)" class="py-2 px-3 bg-gray-200 rounded-lg">remove</button>
                </div>

            </template>
            <p class="text-gray-500 text-sm">Convert as String preview: {{ terms }}</p>
            <p class="text-gray-500 text-sm">Form as String preview: {{ props.term }}</p>
            <form @submit.prevent="form.put(route('terms.update', term.id), { onSuccess: () => form.reset() })">
                <input type="text" v-model="form.value" class="w-full"/>
                <PrimaryButton class="mt-4">Update</PrimaryButton>
            </form>
        </div>
    </AppLayout>
</template>
