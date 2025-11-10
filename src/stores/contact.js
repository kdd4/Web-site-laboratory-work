import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useContactStore = defineStore('contact', () => {
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

	return { fields };
});
