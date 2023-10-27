<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import VueDatePickerProps from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import slugify from 'slugify';
import QsBasic from '@/Components/Question/QsBasic.vue';
import QsYesNo from '@/Components/Question/QsYesNo.vue';

const props = defineProps({
    sessions: Array,
    quiz: Object,
});

const tab = ref('quiz');
const showAddQuestionModal = ref(false);
const types = {
    QsBasic: {
        comName: QsBasic,
        comAnswers: [{content: ''}]
    },
    QsYesNo: {
        comName: QsYesNo,
        comAnswers: []
    },
};

const questions = ref([
    {
        type: 'QsBasic',
        active: true,
        level: 0,
        score: 0,
        content: 'question default',
        answers: []
    }
]);

const form = useForm({
    title: '',
    slug: '',
    summary: '',
    type: '0',
    published: '0',
    published_at: null,
    start_at: '',
    end_at: '',
    content: '',
    questions: [
        {
            type: 'QsBasic',
            active: true,
            level: 0,
            score: 0,
            content: '',
            answers: [{
                active: true,
                correct: false,
                content: ''
            }]
        }
    ]
});

const autoSlug = () => {
    if(form.title != '') {
        form.slug = slugify(form.title);
    } else {
        form.slug = '';
    }
};

/* const addQuestion = () => {
    form.questions.push({
        type: 'basic',
        active: true,
        level: 0,
        score: 0,
        content: '',
        answers: [{
            active: true,
            correct: false,
            content: ''
        }]
    });
} */

const addQuestion = (mtype) => {
    form.questions.push({
        type: mtype,
        active: true,
        level: 0,
        score: 0,
        content: '',
        answers: types[mtype].comAnswers
    });
    showAddQuestionModal.value = false;
    console.log(types[mtype]);
}

const removeQuestion = (index) => {
    form.questions.splice(index, 1);
}

</script>

<template>
    <AppLayout title="Quiz Create">

        <div>
            <form @submit.prevent="form.post(route('quizzes.store'), { onSuccess: () => form.reset() })">
                <div class="mb-4">
                    <input
                        id="title"
                        v-model="form.title"
                        type="text"
                        class="block w-full font-bold text-xl rounded-lg"
                        placeholder="Quiz title..."
                        required
                        autofocus
                        autocomplete="title"
                        @input="autoSlug"
                    />
                    <InputError class="mt-2" :message="form.errors.title" />
                </div>

                <div class="sticky top-0 my-4">
                    <ul class="flex bg-gray-300 text-gray-500 border-b-2 border-blue-600 list-none rounded-t-lg">
                        <li>
                            <button type="button" class="inline-block py-2 px-4 rounded-t-lg" :class="{'text-white bg-blue-600': tab === 'quiz' }" @click.prevent="tab = 'quiz'">Quiz</button>
                        </li>
                        <li>
                            <button type="button" class="inline-block py-2 px-4 rounded-t-lg" :class="{'text-white bg-blue-600': tab === 'setting' }" @click.prevent="tab = 'setting'">Setting</button>
                        </li>
                    </ul>
                </div>



                <div v-if="tab === 'setting'" class="">

                    <textarea
                    v-model="form.summary"
                    placeholder="Summary..."
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    ></textarea>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="my-6">
                            <InputLabel for="type" value="Type" />
                            <select v-model="form.type" name="type" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="0">Default</option>
                                <option value="1">Custom</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.type" />
                        </div>

                        <div class="my-6">
                            <InputLabel for="published" value="Published" />
                            <select v-model="form.published" name="published" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.type" />
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 md:gap-4">
                        <div class="my-6">
                            <InputLabel for="start_at" value="Start At" />
                            <VueDatePickerProps v-model="form.start_at" placeholder="Choosing start date ..." text-input :min-date="new Date()"></VueDatePickerProps>
                            <InputError class="mt-2" :message="form.errors.start_at" />
                        </div>

                        <div class="my-6">
                            <InputLabel for="end_at" value="End At" />
                            <VueDatePickerProps v-model="form.end_at"  placeholder="Choosing end date ..." text-input :min-date="new Date()"></VueDatePickerProps>
                            <InputError class="mt-2" :message="form.errors.end_at" />
                        </div>
                    </div>

                    <textarea
                        v-model="form.content"
                        placeholder="Content..."
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    ></textarea>
                    <InputError :message="form.errors.content" class="mt-2" />

                </div>

                <div v-if="tab === 'quiz'" class="my-4">
                    <h2 class="my-6 font-bold">List Questions</h2>

                    <div v-for="(question, index) in form.questions"
                        class="relative">
                        <component :is="types[form.questions[index].type].comName"
                            :order="index + 1"
                            v-model:type="form.questions[index].type"
                            v-model:active="form.questions[index].active"
                            v-model:level="form.questions[index].level"
                            v-model:score="form.questions[index].score"
                            v-model:content="form.questions[index].content"
                            v-model:answers="form.questions[index].answers"
                            />
                        <button type="button" @click.prevent="removeQuestion(index)" class="absolute top-0 right-4 py-4 pl-2 pr-0 text-red-800 rounded-full">
                            <svg class="block w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill="currentColor" d="M9.12856092,0 L11.102803,0.00487381102 C11.8809966,0.0985789507 12.5627342,0.464975115 13.1253642,1.0831551 C13.583679,1.58672038 13.8246919,2.17271137 13.8394381,2.81137259 L19.3143116,2.81154887 C19.6930068,2.81154887 20,3.12136299 20,3.50353807 C20,3.88571315 19.6930068,4.19552726 19.3143116,4.19552726 L17.478,4.195 L17.4783037,15.8224356 C17.4783037,18.3654005 16.529181,20 14.4365642,20 L5.41874994,20 C3.32701954,20 2.39315828,18.3737591 2.39315828,15.8224356 L2.393,4.195 L0.685688428,4.19552726 C0.306993166,4.19552726 0,3.88571315 0,3.50353807 C0,3.12136299 0.306993166,2.81154887 0.685688428,2.81154887 L6.15581653,2.81128823 C6.17048394,2.29774844 6.36057711,1.7771773 6.7098201,1.26219866 C7.23012695,0.494976667 8.04206594,0.0738475069 9.12856092,0 Z M16.106,4.195 L3.764,4.195 L3.76453514,15.8224356 C3.76453514,17.7103418 4.28461756,18.6160216 5.41874994,18.6160216 L14.4365642,18.6160216 C15.5759705,18.6160216 16.1069268,17.7015972 16.1069268,15.8224356 L16.106,4.195 Z M6.71521035,6.34011422 C7.09390561,6.34011422 7.40089877,6.64992834 7.40089877,7.03210342 L7.40089877,15.0820969 C7.40089877,15.464272 7.09390561,15.7740861 6.71521035,15.7740861 C6.33651508,15.7740861 6.02952192,15.464272 6.02952192,15.0820969 L6.02952192,7.03210342 C6.02952192,6.64992834 6.33651508,6.34011422 6.71521035,6.34011422 Z M9.44248307,6.34011422 C9.82117833,6.34011422 10.1281715,6.64992834 10.1281715,7.03210342 L10.1281715,15.0820969 C10.1281715,15.464272 9.82117833,15.7740861 9.44248307,15.7740861 C9.06378781,15.7740861 8.75679464,15.464272 8.75679464,15.0820969 L8.75679464,7.03210342 C8.75679464,6.64992834 9.06378781,6.34011422 9.44248307,6.34011422 Z M12.1697558,6.34011422 C12.5484511,6.34011422 12.8554442,6.64992834 12.8554442,7.03210342 L12.8554442,15.0820969 C12.8554442,15.464272 12.5484511,15.7740861 12.1697558,15.7740861 C11.7910605,15.7740861 11.4840674,15.464272 11.4840674,15.0820969 L11.4840674,7.03210342 C11.4840674,6.64992834 11.7910605,6.34011422 12.1697558,6.34011422 Z M9.17565461,1.38234438 C8.53434679,1.42689992 8.11102741,1.64646338 7.84152662,2.04385759 C7.6437582,2.33547837 7.5448762,2.58744977 7.52918786,2.81194335 L12.4673768,2.81085985 C12.4530266,2.51959531 12.3382454,2.26423777 12.1153724,2.01935991 C11.7693001,1.63911901 11.3851686,1.43266964 11.0215648,1.38397839 L9.17565461,1.38234438 Z"></path></svg>
                        </button>
                    </div>

                </div>

                <div class="my-4 flex bg-blue-700 text-white rounded-full">
                    <button type="button" @click.prevent="addQuestion('QsBasic')" class="block w-full py-2 px-3">Add Question</button>
                    <button type="button" @click.prevent="showAddQuestionModal = true" class="block px-2 border-l border-blue-900">
                        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"><g id="Menu / More_Grid_Small"><g id="Vector"><path d="M14 15C14 15.5523 14.4477 16 15 16C15.5523 16 16 15.5523 16 15C16 14.4477 15.5523 14 15 14C14.4477 14 14 14.4477 14 15Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8 15C8 15.5523 8.44772 16 9 16C9.55228 16 10 15.5523 10 15C10 14.4477 9.55228 14 9 14C8.44772 14 8 14.4477 8 15Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M14 9C14 9.55228 14.4477 10 15 10C15.5523 10 16 9.55228 16 9C16 8.44772 15.5523 8 15 8C14.4477 8 14 8.44772 14 9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8 9C8 9.55228 8.44772 10 9 10C9.55228 10 10 9.55228 10 9C10 8.44772 9.55228 8 9 8C8.44772 8 8 8.44772 8 9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g></g></svg>
                    </button>

                    <Transition name="fade">
                        <div v-if="showAddQuestionModal" class="fixed top-0 bottom-0 left-0 right-0 bg-gray-800/50" @click.prevent="showAddQuestionModal = false">
                        </div>
                    </Transition>

                    <Transition name="slide-fade">
                            <div v-if="showAddQuestionModal" class="fixed bottom-0 left-0 w-full">

                                <div class="p-8 md:max-w-6xl md:mx-auto  bg-white text-gray-800 border border-gray-300 shadow-xl rounded-t-3xl">
                                    <h3 class="text-gray-600">Select a question type to add:</h3>

                                    <div class="my-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 text-white">
                                        <button v-for="mtype in types" type="button" class="py-2 px-3 bg-blue-700 rounded-full" @click.prevent="addQuestion(mtype.comName.__name)">{{ mtype.comName.__name }}</button>
                                    </div>
                                </div>

                            </div>
                    </Transition>

                </div>
                <div class="my-4">
                    <button type="button" @click.prevent="console.log(form)" class="block w-full py-2 px-3 bg-blue-500 text-white rounded-full">Show Question</button>
                </div>
                <PrimaryButton class="mt-4">Save</PrimaryButton>
            </form>
        </div>
    </AppLayout>
</template>
