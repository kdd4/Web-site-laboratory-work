import { defineStore } from 'pinia';
import { ref, watch } from 'vue';
import { useAuthStore } from './auth';

export const useMathTestStore = defineStore('mathTest', () => {
	const showError = ref(false);
	const showGood = ref(false);
	const showBad = ref(false);

	const formdata = ref({ reset: true });

	const formfields = ref([
		{
			label: 'ФИО',
			type: 'text',
			name: 'fio',
			placeholder: 'Введите ФИО',
			fieldValue: '',
			hasError: false,
			isCorrect: false,
		},
		{
			header: '1-й вопрос',
			text: 'Введите значение натурального логарифма с точностью до десятых',
			type: 'text',
			name: 'question1',
			placeholder: 'Введите ответ',
			fieldValue: '',
			hasError: false,
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

	async function checkTest() {
		let wrongAnswers = false;
		let correctAnswers = false;

		for (let field of formfields.value) {
			let wrong = !field.fieldValue;

			field.hasError = wrong;
			wrongAnswers ||= wrong;
		}

		if (!wrongAnswers) {
			let form = document.getElementById('form');

			let response = await fetch('/api/test/form', {
				method: 'POST',
				headers: {
					Accept: 'application/json',
				},
				body: new FormData(form),
			});
			let response_json = await response.json();
			correctAnswers = response_json.result;
		}

		showError.value = wrongAnswers;
		showGood.value = correctAnswers && !wrongAnswers;
		showBad.value = !correctAnswers && !wrongAnswers;

		await getTestResults();
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

	async function getTestResults() {
		let response = await fetch('/api/test/results', {
			headers: {
				Accept: 'application/json',
			},
		});

		let list = await response.json();

		if (!list.length) {
			testResults.value = [];
			return;
		}

		list = list.map((line) => [line.date, line.fio, line.result ? 'Good' : 'Bad']);

		testResults.value = [['Дата', 'ФИО', 'Результат'], ...list];
	}

	const auth = useAuthStore();

	watch(() => auth.isAuth, getTestResults);

	const testResults = ref([]);

	return { formdata, formfields, messages, testResults, checkTest, resetTest };
});
