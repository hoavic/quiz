<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import vueRecaptcha from 'vue3-recaptcha2';

const props = defineProps({
    sessions: Array,
    quiz: Object,
    take: Object
});

/* console.log(props.take); */
let step = ref(0);
let submited = ref(false);

const form = useForm({
    quiz_id: props.quiz.id,
    status: 0,
    score: 0,
    published: 0,
    published_at: '',
    started_at: '',
    finished_at: '',
    content: '',
    takeAnswers: [],
    captcha_token: null
});

const loadingTimeout = 30000;

const recaptchaVerified = (response) => {
    console.log(response);
    form.captcha_token = response;
}

const recaptchaExpired = () => {
    this.$refs.vueRecaptcha.reset();
}

const recaptchaFailed = () => {
}

const recaptchaError = (reason) => {
}

const nextStep = () => {
/*     console.log(form.takeAnswers[step.value]); */
    if(form.takeAnswers[step.value] === undefined) {return alert('Lỗi! Chưa trả lời hết.');}

    step.value = step.value + 1;
    /* console.log(props.quiz.questions.length); */
}

const prevStep = () => {
    step.value = step.value - 1;
    /* console.log(step.value); */
}

const submitForm = () => {
    console.log(form.takeAnswers);

    if (form.takeAnswers.length === 0) {return alert('Lỗi! Chưa trả lời hết.');}

/*     form.takeAnswers.forEach((answer) => {
        console.log(answer);
        if(answer === null) {return alert('Lỗi! Chưa trả lời hết.');}
    }); */

    if(props.take) {
        form.put(route('takes.update', form), { onSuccess: () => {submited.value = true; form.reset() }  });
    } else {
        form.post(route('takes.store'), { onSuccess: () => {submited.value = true; form.reset() } });
    }

}

const calculateScore =() => {
    form.takeAnswers.forEach((answer) => {
        console.log(answer);
        if(answer === null) {return alert('Lỗi! Chưa trả lời hết.');}
    });
}

const setAnswerData = (q, a) => {
    return {
        question_id: q,
        answer_id: a,
        actice: true,
        content: ''
    };
}

</script>

<template>
    <GuestLayout :title="quiz.title">
        <template #header>
            {{ quiz.title }}
        </template>

        <div class="my-4 text-gray-600">
            {{ quiz.summary }}
        </div>

        <div v-if="form.hasErrors" class="mb-4 p-4 border border-red-800 text-red-800 bg-red-100 rounded-lg">
            <ul>
                <li v-for="err in form.errors" class="">{{ err }}</li>
            </ul>
        </div>

        <div class="pb-16" v-if="!submited">
            <form class="">
                <h2 v-if="step < quiz.questions.length" class="text-center text-gray-600 text-sm">Câu hỏi {{ step + 1 }}/{{ quiz.questions.length }}</h2>
    <!--          <span>{{ quiz.questions }}</span> -->
                <template v-for="(question, indexQ) in quiz.questions">
                    <Transition name="bounce">
                        <div v-if="step == indexQ" class="my-4 md:my-8 py-2 px-4 md:py-8 md:px-8 text-center bg-white rounded-lg">
                            <h3 class="my-6 font-bold text-xl">{{ indexQ + 1 }}. {{ question.name }}</h3>
                            <div class="my-6 md:my-6 grid md:grid-cols-2 gap-4 md:gap-6">
                                <label v-for="(answer, indexA) in question.answers" class="flex flex-col justify-center text-gray-800 rounded-lg transition-all"
                                        :class="(form.takeAnswers[indexQ] && form.takeAnswers[indexQ].answer_id ===  answer.id) ? 'bg-blue-200' : 'bg-gray-100'">

                                        <span class="block py-3 px-4 cursor-pointer">{{ answer.name }}</span>
                                        <input type="radio" v-model="form.takeAnswers[indexQ]" :value="setAnswerData(question.id, answer.id)" hidden @change="console.log(form.takeAnswers)" class="hidden" />

                                </label>
                            </div>
                        </div>
                    </Transition>
                </template>

                <Transition name="bounce">
                    <div v-if="step == quiz.questions.length" class="my-6 p-4 bg-blue-50 text-center border border-blue-200 rounded-lg">
                        <h3 class="my-6 font-bold text-2xl">Xác nhận?</h3>
                        <div class="my-4">
                            <p>Vui lòng kiểm tra lại mọi thông tin trước khi nhấn nút Hoàn thành bên dưới!</p>
                            <p>Nhấn nút <span @click="prevStep" class="text-blue-800 cursor-pointer">Trở lại</span> để chỉnh sửa.</p>
                            <p>Xác nhận để tiếp tục!</p>
                        </div>
                        <div class="mt-4 mb-6 flex justify-center">
                            <vue-recaptcha sitekey="6LeOHPAoAAAAAHxOo9OWasU1KmT3kTarIRj405S5"
                                size="normal"
                                theme="light"
                                hl="vi"
                                :loading-timeout="loadingTimeout"
                                @verify="recaptchaVerified"
                                @expire="recaptchaExpired"
                                @fail="recaptchaFailed"
                                @error="recaptchaError"
                                >
                            </vue-recaptcha>
                        </div>

                    </div>
                </Transition>

            </form>

            <!-- Navi -->
            <div class="fixed bottom-0 left-0 right-0 bg-white border border-gray-200">
                <div class="max-w-7xl mx-auto py-4 px-4 w-full flex flex-row-reverse gap-4 justify-between ">
                    <button v-if="step != quiz.questions.length" type="button" @click.prevent="nextStep(); console.log(form.takeAnswers);" class="px-4 py-2 bg-blue-800 text-white border border-blue-800 rounded-full">Tiếp</button>
                    <button v-if="step === quiz.questions.length" type="button"
                        @click.prevent="submitForm" class="px-4 py-2 bg-green-800 disabled:bg-gray-200 text-white border green-blue-800 rounded-full"
                        :disabled="form.captcha_token === null">Hoàn thành</button>
                    <button v-if="step != 0" type="button" @click.prevent="prevStep" class="px-4 py-2 text-blue-800 border border-blue-800 rounded-full">Trở lại</button>
                </div>
            </div>
        </div>

        <Transition name="bounce">

            <div v-if="submited" class="">

                <div class="my-6 p-4 bg-yellow-50 text-center border border-yellow-200 rounded-lg">
                    <h2 class="my-6 font-bold text-2xl">Đã gửi!</h2>

                    <div class="my-4">
                        <p>Tình trạng: {{ form.status }}</p>
                        <p>Điểm: {{ form.score }}</p>
                        <p>Ghi chú: {{ form.content }}</p>
                    </div>

                    <button v-if="step != 0" type="button" @click.prevent="submited = false; step = 0; form.reset()" class="px-4 py-2 text-blue-800 border border-blue-800 rounded-full">Trở lại</button>

                </div>

                <h3 class="my-6">Câu trả lời của bạn:</h3>

                <ul>
                    <template v-for="(takeAnswer, qIndex) in form.takeAnswers">
                        <li v-if="takeAnswer">#{{ takeAnswer.question_d}}: {{ takeAnswer.answer_id}}</li>
                    </template>
                </ul>

            </div>
        </Transition>

    </GuestLayout>
</template>
