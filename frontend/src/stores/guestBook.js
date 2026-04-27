import { defineStore } from 'pinia';
import { ref, watch, watchEffect } from 'vue';

export const useGuestBookStore = defineStore('guest book', () => {
	const fileAllowSubmit = ref(false);
	const fileShowError = ref(false);
	const fileErrorHTML = ref('');

	const fileFormData = ref({
		allowSubmit: fileAllowSubmit,
	});

	const fileFields = ref({
		file: {
			label: 'Файл',
			type: 'file',
			name: 'feedbackFile',
			accept: '.inc',
			change: (l) => (fileAllowSubmit.value = l.length != 0),
			hasError: false,
			isCorrect: false,
		},
	});

	async function fileSubmit() {
		let form = document.getElementById('fileForm');

		let response = await fetch('/api/guest-book/file', {
			method: 'POST',
			headers: {
				Accept: 'text/plain',
			},
			body: new FormData(form),
		});

		fileErrorHTML.value = await response.text();
		fileShowError.value = true;

		await getFeedbackList();
	}

	const feedbackAllowSubmit = ref(false);
	const feedbackShowError = ref(false);
	const feedbackErrorHTML = ref('');

	const feedbackFormData = ref({
		allowSubmit: feedbackAllowSubmit,
	});

	const feedbackFields = ref({
		fio: {
			label: 'ФИО',
			type: 'text',
			name: 'fio',
			placeholder: 'Введите ФИО',
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
		feedback: {
			label: 'Отзыв',
			type: 'textarea',
			name: 'feedback',
			placeholder: 'Введите отзыв',
			fieldValue: '',
			hasError: false,
			isCorrect: false,
		},
	});

	async function feedbackSubmit() {
		let form = document.getElementById('feedbackForm');

		let response = await fetch('/api/guest-book/form', {
			method: 'POST',
			headers: {
				Accept: 'text/plain',
			},
			body: new FormData(form),
		});

		feedbackErrorHTML.value = await response.text();
		feedbackShowError.value = true;

		await getFeedbackList();
	}

	function checkFIO() {
		feedbackFields.value.fio.hasError = !feedbackFields.value.fio.fieldValue;
		feedbackFields.value.fio.isCorrect = !feedbackFields.value.fio.hasError;
	}

	function checkEmail() {
		feedbackFields.value.email.hasError = !feedbackFields.value.email.fieldValue;
		feedbackFields.value.email.isCorrect = !feedbackFields.value.email.hasError;
	}

	function checkFeedback() {
		feedbackFields.value.feedback.hasError = !feedbackFields.value.feedback.fieldValue;
		feedbackFields.value.feedback.isCorrect = !feedbackFields.value.feedback.hasError;
	}

	function updateAllowSubmit() {
		feedbackAllowSubmit.value =
			feedbackFields.value.fio.isCorrect &&
			feedbackFields.value.email.isCorrect &&
			feedbackFields.value.feedback.isCorrect;
	}

	function updateShowError() {
		feedbackShowError.value =
			feedbackFields.value.fio.hasError ||
			feedbackFields.value.email.hasError ||
			feedbackFields.value.feedback.hasError;

		feedbackErrorHTML.value = 'Не заполнено поле';
	}

	watch(() => feedbackFields.value.fio.fieldValue, checkFIO);
	watch(() => feedbackFields.value.email.fieldValue, checkEmail);
	watch(() => feedbackFields.value.feedback.fieldValue, checkFeedback);
	watchEffect(updateAllowSubmit);
	watchEffect(updateShowError);

	async function getFeedbackList() {
		let response = await fetch('/api/guest-book/feedback', {
			headers: {
				Accept: 'application/json',
			},
		});

		let list = await response.json();

		if (!list.length) {
			feedbackList.value = [];
			return;
		}

		feedbackList.value = [['Дата', 'ФИО', 'E-mail', 'Отзыв'], ...list];
	}

	getFeedbackList();

	const forms = ref([
		{
			id: 'feedbackForm',
			fields: feedbackFields,
			formdata: feedbackFormData,
			showError: feedbackShowError,
			errorHTML: feedbackErrorHTML,
			submit: feedbackSubmit,
		},
		{
			id: 'fileForm',
			fields: fileFields,
			formdata: fileFormData,
			showError: fileShowError,
			errorHTML: fileErrorHTML,
			submit: fileSubmit,
		},
	]);

	const feedbackList = ref([]);

	return {
		forms,
		feedbackList,
	};
});
