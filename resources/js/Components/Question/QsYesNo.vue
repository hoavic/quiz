<script setup>

import { ref, watch, onMounted } from 'vue';
import AnsYesNo from '../Answer/TextNumber/AnsYesNo.vue';

const props = defineProps({
    order: Number,
    type: {
        type: String,
        default: 'QsYesNo'
    },
    active: {
        type: Boolean,
        default: true
    },
    level: Number,
    score: Number,
    name: {
        type: String,
        default: '',
    },
    description: {
        type: String,
        default: '',
    },
    answers: {
        type: Array,
        default: [
            {
                active: true,
                correct: true,
                name: true,
                description: ''
            },
            {
                active: true,
                correct: false,
                name: false,
                description: ''
            }
        ]
    },
});

const showAnswers = ref(true);

defineEmits(['update:type', 'update:active', 'update:level', 'update:score', 'update:name', 'update:description', 'update:answers']);

onMounted(() => {

    if(props.answers.length === 0) {
        addAnswer();
    }

});

const addAnswer = () => {
    props.answers.push(
        {
            active: true,
            correct: true,
            name: true,
            description: ''
        },
        {
            active: true,
            correct: false,
            name: false,
            description: ''
        },
    );
}

const setCorrect = (order) => {
    if(props.answers[order].correct === true) {
        props.answers.forEach(async (value, index) => {
            if(index != order) {
                props.answers[index].correct = false;
            }
        });
        /* console.log(props.answers); */
    }
}

</script>


<template>
    <div class="my-4 p-4 bg-gray-200 rounded-lg">
        <div class="mb-4 pr-12 flex justify-between gap-4">
            <h2 class="text-sm font-bold">Q{{ order }}: {{ type }}</h2>
            <button type="button" @click.prevent="showAnswers = !showAnswers" class="text-gray-500 rounded-full" :class="{'rotate-180': !showAnswers}">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill="currentColor" d="M10,0 C15.5228475,0 20,4.4771525 20,10 C20,15.5228475 15.5228475,20 10,20 C4.4771525,20 0,15.5228475 0,10 C0,4.4771525 4.4771525,0 10,0 Z M10,1.39534884 C5.24778239,1.39534884 1.39534884,5.24778239 1.39534884,10 C1.39534884,14.7522176 5.24778239,18.6046512 10,18.6046512 C14.7522176,18.6046512 18.6046512,14.7522176 18.6046512,10 C18.6046512,5.24778239 14.7522176,1.39534884 10,1.39534884 Z M9.51942697,7.63613781 C9.78350334,7.37374613 10.2092302,7.37167573 10.4758462,7.63148655 L10.4758462,7.63148655 L14.4473588,11.5016301 C14.7170449,11.7644327 14.7226251,12.1961 14.4598225,12.4657861 C14.1970199,12.7354721 13.7653526,12.7410523 13.4956665,12.4782497 L13.4956665,12.4782497 L10.0046519,9.07633992 L6.58558122,12.4735984 C6.31846398,12.7390116 5.8867628,12.7376302 5.62134964,12.4705129 C5.35593648,12.2033957 5.35731792,11.7716945 5.62443516,11.5062813 L5.62443516,11.5062813 Z"></path></svg>
            </button>
        </div>
        <div class="mb-4 flex gap-2">
            <input
                type="text"
                placeholder="Enter question..."
                :value="name"
                @input="$emit('update:name', $event.target.value)"
                class="w-full font-bold text-blue-700 border border-gray-300 rounded-lg"
            >
        </div>

        <div v-if="showAnswers" class="grid md:grid-cols-2 gap-4 rounded-lg">
            <template v-for="(answer, indexA) in props.answers">
                <div class="p-4 w-full flex items-start bg-gray-300 rounded-lg">
                    <AnsYesNo
                        :order="indexA"
                        v-model:active="props.answers[indexA].active"
                        v-model:correct="props.answers[indexA].correct"
                        v-model:name="props.answers[indexA].name"
                        @correctUpdated="setCorrect"
                        />
                </div>
            </template>
        </div>

        <div class="mt-2 text-center text-sm text-gray-600"><span>{{ props.answers.length }}</span> câu trả lời <span v-if="showAnswers === false" class="text-blue-600" @click.prevent="showAnswers = true">hiển thị tất cả</span></div>
    </div>


</template>
