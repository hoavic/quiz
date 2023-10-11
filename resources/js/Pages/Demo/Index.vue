<script setup>
import { Link } from '@inertiajs/vue3';
import {ref} from "vue";
import AppLayout from '@/Layouts/AppLayout.vue';
import { Transition } from 'vue';

defineProps({
    sessions: Array,

});

const take = ref([]);

const questions = [
    {
        title: 'Question 1',
        description: 'How old are you?',
        answers: [
            {
                value: '11',
                label: '11',
            },
            {
                value: '22',
                label: '22',
            },
            {
                value: '33',
                label: '33',
            },
            {
                value: '44',
                label: '44',
            },
        ]
    },
    {
        title: 'Question 2',
        description: 'What is your name?',
        answers: [
            {
                value: 'Alice',
                label: 'Alice',
            },
            {
                value: 'Thane',
                label: 'Thane',
            },
            {
                value: 'Yorn',
                label: 'Yorn',
            },
            {
                value: 'Maxx',
                label: 'Maxx',
            },
        ]
    },
    {
        title: 'Question 3',
        description: 'Where are you from?',
        answers: [
            {
                value: 'Oslo',
                label: 'Oslo',
            },
            {
                value: 'London',
                label: 'London',
            },
            {
                value: 'New York',
                label: 'New York',
            },
            {
                value: 'Hanoi',
                label: 'Hanoi',
            },
        ]
    }
];

var maxStep = questions.length;
const step = ref(1);
/* const question1 = ref(null); */
const complete = ref(false);


const nextStep = () => {
    step.value++;
}


</script>

<template>
    <AppLayout title="Demo">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Demo
            </h2>
            <Link :href="route('quizzes.create')"></Link>
        </template>

        <div class="text-gray-600">

            <!-- <p class="text-center">{{ step }}/{{ maxStep }}</p> -->

            <!-- Q1 -->
<!--             <div v-if="step === 1" class="">
                <h3>Question 1</h3>
                <p>How old are you?</p>
                <div class="my-4 grid grid-cols-2 gap-4">
                    <label class="px-4 py-2 flex items-center gap-2 bg-white peer-checked:bg-blue-300 text-gray-600 rounded-lg"><input type="radio" v-model="question1" value="11" class="peer rounded"/> 11</label>
                    <label class="px-4 py-2 flex items-center gap-2 bg-white peer-checked:bg-blue-300 text-gray-600 rounded-lg"><input type="radio" v-model="question1" value="22" class="peer rounded"/> 22</label>
                    <label class="px-4 py-2 flex items-center gap-2 bg-white peer-checked:bg-blue-300 text-gray-600 rounded-lg"><input type="radio" v-model="question1" value="33" class="peer rounded"/> 33</label>
                    <label class="px-4 py-2 flex items-center gap-2 bg-white peer-checked:bg-blue-300 text-gray-600 rounded-lg"><input type="radio" v-model="question1" value="44" class="peer rounded"/> 44</label>
                </div>
            </div> -->

            <h1 class="my-4 text-2xl font-bold">Quiz Title</h1>

            <div v-if="!complete">
                <p class="text-center">{{ step }}/{{ questions.length }}</p>

                <template v-for="(question, index) in questions" :key="index">
                    <template v-if="step === (index + 1)">
                        <div class="">
                            <h3>Q: {{ question.title }}</h3>
                            <p>{{ question.description }}</p>
                            <div class="my-4 grid grid-cols-2 gap-4">
                                <template v-for="answer in question.answers">
                                    <label>
                                        <input type="radio" v-model="take[index]" :value="answer.value" class="peer hidden"/>
                                        <span class="px-4 py-2 flex items-center gap-2 bg-white peer-checked:bg-blue-500 text-gray-600 peer-checked:text-white rounded-lg">{{ answer.label }}</span>
                                    </label>
                                </template>
                            </div>
                        </div>
                    </template>
                </template>

                <!-- Logs -->
                <div class="">
                    {{ take }}
                </div>

                <!-- Nav -->
                <div class="fixed left-0 bottom-0 w-full p-4 bg-white border-t border-gray-200">
                    <div class="flex justify-between">
                        <button v-if="step > 1" @click="step--" class="px-4 py-2 bg-white border border-gray-300 rounded-lg">Trở lại</button>
                        <button v-if="step < maxStep" @click="nextStep"  class="px-4 py-2 bg-blue-500 text-white border border-gray-300 rounded-lg">Tiếp</button>
                        <button v-if="step === maxStep" @click="complete = true"  class="px-4 py-2 bg-blue-500 text-white border border-gray-300 rounded-lg">Hoàn thành</button>
                    </div>
                </div>
            </div>

            <Transition name="animate-bounce">
                <div v-if="complete" class="py-6 px-4 bg-white text-center rounded-lg">
                    <h2 class="my-6 text-3xl font-bold">Congratulations!</h2>
                    <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg" @click="complete = false; step = 1">Quay lại</button>
                </div>
            </Transition>

        </div>

    </AppLayout>
</template>
