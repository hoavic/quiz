<script setup>
import InputLabel from '@/Components/InputLabel.vue';


const props = defineProps({
    keyModel: String
});

</script>

<template>
    <InputLabel for="value" value="Value as String" />
    <textarea
        id="description"
        v-model="props.keyModel"
        placeholder="Description..."
        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
    ></textarea>
</template>
