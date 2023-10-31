<script setup>

defineProps({
    order: Number,
    active: {
        type: Boolean,
        default: false
    },
    correct: {
        type: Boolean,
        default: false
    },
    name: {
        type: String,
        default: '',
    },
    description: {
        type: String,
        default: '',
    },
});

defineEmits(['update:active', 'update:correct', 'update:name', 'update:description', 'update:correct', 'correctUpdated']);

</script>

<template>

    <div class="w-full">
        <input
            type="text"
            :value="name"
            placeholder="type answer..."
            @input="$emit('update:name', $event.target.value)"
            class="w-full text-gray-600 border border-gray-300 rounded-lg"
            :class="{'bg-green-100': correct}"
        >

        <div class="my-2 flex gap-4">

            <label class="flex items-center gap-2 text-sm text-gray-500">
                <input
                    type="checkbox"
                    :checked="active"
                    disabled
                    @change="$emit('update:active', $event.target.checked)"
                    class="border border-gray-300 rounded-lg"
                >
                <span v-if="active">đang bật</span>
                <span v-if="!active">đang tắt</span>
            </label>

            <label class="flex items-center gap-2 text-sm text-gray-500">
                <input
                    type="checkbox"
                    :checked="correct"
                    :disabled="correct"
                    @change="$emit('update:correct', $event.target.checked); $emit('correctUpdated', order)"
                    class="border border-gray-300 rounded-lg"
                >
                <span>đáp án đúng</span>
            </label>

        </div>
    </div>

</template>
