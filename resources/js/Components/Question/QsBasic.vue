<script setup>

import { ref, onMounted } from 'vue';
import AnsText from '../Answer/TextNumber/AnsText.vue';

const props = defineProps({
    order: Number,
    type: {
        type: String,
        default: 'QsBasic'
    },
    active: {
        type: Boolean,
        default: true
    },
    level: {
        type: Number,
        default: 0
    },
    score: {
        type: Number,
        default: 0
    },
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
        default: []
    },
});

const showAnswers = ref(true);

defineEmits(['update:type', 'update:active', 'update:level', 'update:score', 'update:name', 'update:description', 'update:answers']);

onMounted(() => {

    if(props.answers.length === 0) {
        addAnswer(true); addAnswer(); addAnswer(); addAnswer();
    }

});

const addAnswer = (isCorrect = false) => {
    props.answers.push({
        active: true,
        correct: isCorrect,
        name: '',
        description: '',
    });
}

const removeAnswer = (index) => {
    props.answers.splice(index, 1);
}


/* watch(
    () => props.answers,
    async (currentValue, oldValue) => {
        console.log(currentValue);
        console.log(oldValue);
    },
    {
        deep: true
    }
); */

const setCorrect = (order) => {
    /* console.log(props.answers[order]); */
    if(props.answers[order].correct === true) {
        props.answers.forEach(async (value, index) => {
            if(index != order) {
                props.answers[index].correct = false;
            }
        });
        console.log(props.answers);
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
            <button type="button" @click.prevent="addAnswer()" class="py-2 px-4 bg-gray-700 text-white rounded-full">+</button>
        </div>

        <div v-if="showAnswers" class="grid md:grid-cols-2 gap-4 rounded-lg">
            <template v-for="(answer, indexA) in props.answers">
                <div class="p-4 w-full flex items-start bg-gray-300 rounded-lg">
                    <AnsText
                        :order="indexA"
                        v-model:active="props.answers[indexA].active"
                        v-model:correct="props.answers[indexA].correct"
                        v-model:name="props.answers[indexA].name"
                        v-model:description="props.answers[indexA].description"
                        @correctUpdated="setCorrect"
                        />
                    <button type="button" @click.prevent="removeAnswer(indexA)" class="py-4 pl-2 pr-0 text-gray-500 rounded-full">
                        <svg class="block w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill="currentColor" d="M9.12856092,0 L11.102803,0.00487381102 C11.8809966,0.0985789507 12.5627342,0.464975115 13.1253642,1.0831551 C13.583679,1.58672038 13.8246919,2.17271137 13.8394381,2.81137259 L19.3143116,2.81154887 C19.6930068,2.81154887 20,3.12136299 20,3.50353807 C20,3.88571315 19.6930068,4.19552726 19.3143116,4.19552726 L17.478,4.195 L17.4783037,15.8224356 C17.4783037,18.3654005 16.529181,20 14.4365642,20 L5.41874994,20 C3.32701954,20 2.39315828,18.3737591 2.39315828,15.8224356 L2.393,4.195 L0.685688428,4.19552726 C0.306993166,4.19552726 0,3.88571315 0,3.50353807 C0,3.12136299 0.306993166,2.81154887 0.685688428,2.81154887 L6.15581653,2.81128823 C6.17048394,2.29774844 6.36057711,1.7771773 6.7098201,1.26219866 C7.23012695,0.494976667 8.04206594,0.0738475069 9.12856092,0 Z M16.106,4.195 L3.764,4.195 L3.76453514,15.8224356 C3.76453514,17.7103418 4.28461756,18.6160216 5.41874994,18.6160216 L14.4365642,18.6160216 C15.5759705,18.6160216 16.1069268,17.7015972 16.1069268,15.8224356 L16.106,4.195 Z M6.71521035,6.34011422 C7.09390561,6.34011422 7.40089877,6.64992834 7.40089877,7.03210342 L7.40089877,15.0820969 C7.40089877,15.464272 7.09390561,15.7740861 6.71521035,15.7740861 C6.33651508,15.7740861 6.02952192,15.464272 6.02952192,15.0820969 L6.02952192,7.03210342 C6.02952192,6.64992834 6.33651508,6.34011422 6.71521035,6.34011422 Z M9.44248307,6.34011422 C9.82117833,6.34011422 10.1281715,6.64992834 10.1281715,7.03210342 L10.1281715,15.0820969 C10.1281715,15.464272 9.82117833,15.7740861 9.44248307,15.7740861 C9.06378781,15.7740861 8.75679464,15.464272 8.75679464,15.0820969 L8.75679464,7.03210342 C8.75679464,6.64992834 9.06378781,6.34011422 9.44248307,6.34011422 Z M12.1697558,6.34011422 C12.5484511,6.34011422 12.8554442,6.64992834 12.8554442,7.03210342 L12.8554442,15.0820969 C12.8554442,15.464272 12.5484511,15.7740861 12.1697558,15.7740861 C11.7910605,15.7740861 11.4840674,15.464272 11.4840674,15.0820969 L11.4840674,7.03210342 C11.4840674,6.64992834 11.7910605,6.34011422 12.1697558,6.34011422 Z M9.17565461,1.38234438 C8.53434679,1.42689992 8.11102741,1.64646338 7.84152662,2.04385759 C7.6437582,2.33547837 7.5448762,2.58744977 7.52918786,2.81194335 L12.4673768,2.81085985 C12.4530266,2.51959531 12.3382454,2.26423777 12.1153724,2.01935991 C11.7693001,1.63911901 11.3851686,1.43266964 11.0215648,1.38397839 L9.17565461,1.38234438 Z"></path></svg>
                    </button>
                </div>
            </template>
        </div>

        <div class="mt-2 text-center text-sm text-gray-600"><span>{{ props.answers.length }}</span> câu trả lời <span v-if="showAnswers === false" class="text-blue-600" @click.prevent="showAnswers = true">hiển thị tất cả</span></div>
    </div>


</template>
