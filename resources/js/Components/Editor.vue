<script setup>
import { computed, onMounted, onUnmounted, watch } from 'vue';

import '@/tinymce/tinymce';
import '@/tinymce/icons/default/icons';
import '@/tinymce/themes/silver/theme';
import '@/tinymce/skins/ui/oxide/skin.css';

const props = defineProps({
    id: 'myeditor',
    placeholder: '',
});

tinymce.init({
    selector: 'textarea#myeditor'
});

</script>

<template>
    <textarea id="myeditor"  class="my-6 h-96 w-full border border-gray-100 rounded">

    </textarea>
</template>
