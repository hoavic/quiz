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
        type: Boolean,
        default: true,
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
        <label class="flex items-center gap-2 text-sm text-gray-500">
            <span v-if="content">Có</span>
            <span v-if="!content">Không</span>
        </label>

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
