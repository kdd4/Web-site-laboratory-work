import { defineStore } from 'pinia';
import { ref, watch, watchEffect } from 'vue';

export const useContactStore = defineStore('contact', () => {
	const showError = ref(false);
	const allowSubmit = ref(false);

	const formdata = ref({
		allowSubmit: allowSubmit,
	});

	const fields = ref({
		fio: {
			label: 'ФИО',
			type: 'text',
			name: 'FIO',
			placeholder: 'Введите ФИО',
			fieldValue: '',
			hasError: false,
			isCorrect: false,
		},
		gender: {
			label: 'Пол',
			type: 'radio',
			name: 'gender',
			options: [
				{ text: 'M', value: 'Male' },
				{ text: 'Ж', value: 'Female' },
			],
			fieldValue: '',
			hasError: false,
			isCorrect: false,
		},
		age: {
			label: 'Возраст',
			type: 'select',
			name: 'age',
			options: [
				{ value: '', text: 'Выберите', disabled: true },
				{ value: 'less16', text: 'До 16', disabled: false },
				{ value: '16-18', text: '16-18', disabled: false },
				{ value: 'more18', text: 'Старше 18', disabled: false },
			],
			fieldValue: '',
			hasError: false,
			isCorrect: false,
		},
		email: {
			label: 'E-mail',
			type: 'text',
			name: 'email',
			placeholder: 'Введите E-mail',
			fieldValue: '',
			hasError: false,
			isCorrect: false,
		},
		number: {
			label: 'Номер',
			type: 'text',
			name: 'number',
			placeholder: 'Введите номер',
			fieldValue: '',
			hasError: false,
			isCorrect: false,
		},
		birthday: {
			label: 'День рождения',
			type: 'date',
			name: 'birthday',
			fieldValue: new Date(Date.now()),
			hasError: false,
			isCorrect: false,
		},
	});

	function checkFIO() {
		let fio_re = /^[а-яёА-ЯЁa-zA-Z]+ [а-яёА-ЯЁa-zA-Z]+ [а-яёА-ЯЁa-zA-Z]+$/;

		fields.value.fio.hasError = !fio_re.test(fields.value.fio.fieldValue);
		fields.value.fio.isCorrect = !fields.value.fio.hasError;
	}

	function checkGender() {
		fields.value.gender.hasError = !fields.value.gender.fieldValue;
		fields.value.gender.isCorrect = !fields.value.gender.hasError;
	}

	function checkAge() {
		fields.value.age.hasError = !fields.value.age.fieldValue;
		fields.value.age.isCorrect = !fields.value.age.hasError;
	}

	function checkEmail() {
		let email_re = /^\w+@\w+.\w{2,}$/;

		fields.value.email.hasError = !email_re.test(fields.value.email.fieldValue);
		fields.value.email.isCorrect = !fields.value.email.hasError;
	}

	function checkNumber() {
		let number_re = /^\+7|3\d{8,10}$/;

		fields.value.number.hasError = !number_re.test(fields.value.number.fieldValue);
		fields.value.number.isCorrect = !fields.value.number.hasError;
	}

	function checkBirthday() {
		fields.value.birthday.hasError = fields.value.birthday.fieldValue.getTime() > Date.now();
		fields.value.birthday.isCorrect = !fields.value.birthday.hasError;
	}

	function updateAllowSubmit() {
		allowSubmit.value =
			fields.value.fio.isCorrect &&
			fields.value.gender.isCorrect &&
			fields.value.age.isCorrect &&
			fields.value.email.isCorrect &&
			fields.value.number.isCorrect &&
			fields.value.birthday.isCorrect;
	}

	function updateShowError() {
		showError.value =
			fields.value.fio.hasError ||
			fields.value.gender.hasError ||
			fields.value.age.hasError ||
			fields.value.email.hasError ||
			fields.value.number.hasError ||
			fields.value.birthday.hasError;
	}

	watch(() => fields.value.fio.fieldValue, checkFIO);
	watch(() => fields.value.gender.fieldValue, checkGender);
	watch(() => fields.value.age.fieldValue, checkAge);
	watch(() => fields.value.email.fieldValue, checkEmail);
	watch(() => fields.value.number.fieldValue, checkNumber);
	watch(() => fields.value.birthday.fieldValue, checkBirthday);
	watchEffect(updateAllowSubmit);
	watchEffect(updateShowError);

	function formSubmit() {
		let form = document.getElementById('form');

		fetch('/api', {
			method: 'POST',
			body: new FormData(form),
		});
	}

	return { fields, showError, formdata, formSubmit };
});
