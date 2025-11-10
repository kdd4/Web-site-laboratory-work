<script setup>
import { computed, ref } from 'vue';
import Form from '@/components/Form.vue';

const showError = ref(false);
const showGood = ref(false);
const showBad = ref(false);

const messages = ref([
	{
		text: 'Ответ(ы) не выбраны или введены не в правильном формате',
		show: showError,
		good: false,
	},
	{
		text: 'Всё верно',
		show: showGood,
		good: true,
	},
	{
		text: 'Есть ошибки',
		show: showBad,
		good: false,
	},
]);

// Current answers
const answer1 = ref('');
const answer2 = ref('');
const answer3 = ref('');

// Show error
const showWrongAnswer1 = ref(false);
const showWrongAnswer2 = ref(false);
const showWrongAnswer3 = ref(false);

// right answers
const rightAnswers = {
	answer1: 2.7,
	answer2: 'r2 sin tetta',
	answer3: 'var1',
};

// Is answers has wrong value
const wrongAnswer1 = computed(() => !answer1.value || isNaN(parseFloat(answer1.value)));
const wrongAnswer2 = computed(() => !answer2.value);
const wrongAnswer3 = computed(() => !answer3.value);

// Is correct current answer
const correctAnswer1 = computed(
	() => !wrongAnswer1.value && Math.abs(answer1.value - rightAnswers.answer1) <= 0.1,
);
const correctAnswer2 = computed(() => !wrongAnswer2.value && answer2.value == rightAnswers.answer2);
const correctAnswer3 = computed(() => !wrongAnswer3.value && answer3.value == rightAnswers.answer3);

// Result of test
const wrongAnswers = computed(() => wrongAnswer1.value || wrongAnswer2.value || wrongAnswer3.value);
const correctAnswers = computed(
	() => correctAnswer1.value && correctAnswer2.value && correctAnswer3.value,
);

function checkTest(event) {
	showWrongAnswer1.value = wrongAnswer1.value;
	showWrongAnswer2.value = wrongAnswer2.value;
	showWrongAnswer3.value = wrongAnswer3.value;

	showError.value = wrongAnswers.value;
	showGood.value = correctAnswers.value && !wrongAnswers.value;
	showBad.value = !correctAnswers.value && !wrongAnswers.value;
}

function resetTest(event) {
	showError.value = false;
	showGood.value = false;
	showBad.value = false;

	showWrongAnswer1.value = false;
	showWrongAnswer2.value = false;
	showWrongAnswer3.value = false;

	answer1.value = '';
	answer2.value = '';
	answer3.value = '';
}

const formdata = { reset: true };

const formfields = ref([
	{
		header: '1-й вопрос',
		text: 'Введите значение натурального логарифма с точностью до десятых',
		type: 'text',
		name: 'question1',
		placeholder: 'Введите ответ',
		fieldValue: answer1,
		hasError: showWrongAnswer1,
	},
	{
		header: '2-й вопрос',
		text: 'Чему равен якобиан преобразования к сферическим координатам',
		type: 'radio',
		name: 'question2',
		options: [
			{ text: 'r<sup>2</sup>sin &#952;', value: 'r2 sin tetta' },
			{ text: 'r<sup>2</sup>cos &#952;', value: 'r2 cos tetta' },
		],
		fieldValue: answer2,
		hasError: showWrongAnswer2,
	},
	{
		header: '3-й вопрос',
		text: 'Определитель не изменится, если:',
		type: 'select',
		name: 'question3',
		options: [
			{ value: '', text: 'Выберите', disabled: true },
			{ value: 'var1', text: 'Переставить местами две строки', disabled: false },
			{
				value: 'var2',
				text: 'Поделить элементы какой-нибудь строки (столбца) на их общий делитель',
				disabled: false,
			},
			{ value: 'var3', text: 'Транспонировать матрицу', disabled: false },
		],
		fieldValue: answer3,
		hasError: showWrongAnswer3,
	},
]);
</script>

<template>
	<main class="flex flex-col items-center space-y-3">
		<h2 class="mb-8 text-center text-2xl font-bold not-md:text-xl">Тест по высшей математике</h2>
		<Form :fields="formfields" :formdata="formdata" @submit="checkTest" @reset="resetTest" />
		<div
			v-for="message in messages"
			v-show="message.show"
			:class="{
				'border-green-500/30 bg-green-400': message.good,
				'border-red-500/30 bg-red-400': !message.good,
			}"
			class="rounded-sm border-2 p-0.5 text-center"
		>
			<p>{{ message.text }}</p>
		</div>
	</main>
</template>
