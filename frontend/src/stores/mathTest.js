import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useMathTestStore = defineStore('mathTest', () => {
	const showError = ref(false);
	const showGood = ref(false);
	const showBad = ref(false);

	const formdata = ref({ reset: true });

	const formfields = ref([
		{
			header: '1-й вопрос',
			text: 'Введите значение натурального логарифма с точностью до десятых',
			type: 'text',
			name: 'question1',
			placeholder: 'Введите ответ',
			fieldValue: '',
			hasError: false,
			rightAnswer: 2.7,
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
			fieldValue: '',
			hasError: false,
			rightAnswer: 'r2 sin tetta',
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
			fieldValue: '',
			hasError: false,
			rightAnswer: 'var1',
		},
	]);

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

	function checkTest() {
		let wrongAnswers = false;
		let correctAnswers = true;

		for (let field of formfields.value) {
			let wrong = !field.fieldValue;

			if (!wrong && typeof field.rightAnswer == 'number') {
				let value = field.fieldValue - 0;

				wrong ||= isNaN(value);
				correctAnswers &&= Math.abs(field.rightAnswer - value) < 0.01;
			} else {
				correctAnswers &&= field.rightAnswer == field.fieldValue;
			}

			field.hasError = wrong;
			wrongAnswers ||= wrong;
		}

		showError.value = wrongAnswers;
		showGood.value = correctAnswers && !wrongAnswers;
		showBad.value = !correctAnswers && !wrongAnswers;
	}

	function resetTest() {
		showError.value = false;
		showGood.value = false;
		showBad.value = false;

		for (let field of formfields.value) {
			field.hasError = false;
			field.fieldValue = '';
		}
	}

	return { formdata, formfields, messages, checkTest, resetTest };
});
