<script setup>

import InputLabel from '@/Components/InputLabel.vue';
import { ref } from 'vue';

const props = defineProps({
    keyModel: String
});

const lists = ref(['default']);


const addItem = () => {
        lists.value.push('');
};

const removeItem = (index) => {
        lists.value.splice(index,1);
};

</script>

<template>
    <InputLabel for="value" value="Value as List" />
    <button type="button" @click.prevent="addItem" class="my-4 py-1 px-3 bg-gray-200 rounded-lg">add</button>
    <template v-for="(list, index) in lists">
        <div class="my-2 flex items-center">
            <input v-model="lists[index]" type="text" :placeholder="'Value ' + index" class="block w-full bg-white border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"/>
            <button type="button" @click.prevent="removeItem(index)" class="p-2">remove</button>
        </div>
    </template>
    <p class="text-gray-500 text-sm">Convert as String preview: {{ lists }}</p>
</template>
