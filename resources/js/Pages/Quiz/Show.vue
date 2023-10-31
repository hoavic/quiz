<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { ref } from 'vue';

const props = defineProps({
    sessions: Array,
    quiz: Object
});

let step = ref(0);

const nextStep = () => {
    step.value = step.value + 1;
    /* console.log(props.quiz.questions.length); */
}

const prevStep = () => {
    step.value = step.value - 1;
    /* console.log(step.value); */
}

</script>

<template>
    <GuestLayout :title="quiz.title">
        <template #header>
            {{ quiz.title }}
        </template>

        <div class="my-4">
            {{ quiz.summary }}
        </div>

        <div class="">
            <h2 v-if="step < quiz.questions.length" class="text-center text-gray-600 text-sm">Câu hỏi {{ step + 1 }}/{{ quiz.questions.length }}</h2>
   <!--          <span>{{ quiz.questions }}</span> -->
            <div v-for="(question, index) in quiz.questions" class="md:px-8 text-center">
                <Transition name="bounce">
                    <div v-if="step == index">
                        <h3 class="my-6 font-bold">{{ index + 1 }}. {{ question.name }}</h3>
                        <div class="my-4 md:my-6 grid grid-cols-2 gap-4 md:gap-6">
                            <div v-for="(answer, indexA) in question.answers" class="py-3 px-4 bg-gray-200 text-gray-800 rounded-lg">
                                <span>{{ answer.name }}</span>
                            </div>
                        </div>
                    </div>
                </Transition>
            </div>

            <Transition name="bounce">
                <div v-if="step == quiz.questions.length" class="my-6 p-4 bg-blue-50 text-center border border-blue-200 rounded-lg">
                    <h3 class="my-6 font-bold text-2xl">Xác nhận?</h3>
                    <div class="my-4">
                        <p>Vui lòng kiểm tra lại mọi thông tin trước khi nhấn nút Hoàn thành bên dưới!</p>
                        <p>Nhấn nút Trở lại để chỉnh sửa.</p>
                    </div>
                </div>
            </Transition>

        </div>

        <!-- Navi -->
        <div class="fixed bottom-0 left-0 right-0 bg-white shadow-lg">
            <div class="max-w-7xl mx-auto py-4 px-4 w-full flex flex-row-reverse gap-4 justify-between ">
                <button v-if="step != quiz.questions.length" type="button" @click.prevent="nextStep" class="px-4 py-2 bg-blue-800 text-white border border-blue-800 rounded-full">Tiếp</button>
                <button v-if="step === quiz.questions.length" type="button" @click.prevent="" class="px-4 py-2 bg-green-800 text-white border green-blue-800 rounded-full">Hoàn thành</button>
                <button v-if="step != 0" type="button" @click.prevent="prevStep" class="px-4 py-2 text-blue-800 border border-blue-800 rounded-full">Trở lại</button>
            </div>
        </div>



    </GuestLayout>
</template>
