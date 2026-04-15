import { defineStore } from 'pinia';
import { ref, watch, watchEffect } from 'vue';

export const useGuestBookStore = defineStore('guest book', () => {
	const showError = ref(false);
	const allowSubmit = ref(false);

	const errorHTML = ref("");

	const formdata = ref({
		allowSubmit: allowSubmit,
	});

	const fields = ref({
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

    const feedbackList = ref([]);

	function checkFIO() {
		fields.value.fio.hasError = !fields.value.fio.fieldValue;
		fields.value.fio.isCorrect = !fields.value.fio.hasError;
	}

	function checkEmail() {
		fields.value.email.hasError = !fields.value.email.fieldValue;
		fields.value.email.isCorrect = !fields.value.email.hasError;
	}

	function checkFeedback() {
		fields.value.feedback.hasError = !fields.value.feedback.fieldValue;
		fields.value.feedback.isCorrect = !fields.value.feedback.hasError;
	}

	function updateAllowSubmit() {
		allowSubmit.value =
			fields.value.fio.isCorrect &&
			fields.value.email.isCorrect &&
			fields.value.feedback.isCorrect;
	}

	function updateShowError() {
		showError.value =
			fields.value.fio.hasError ||
			fields.value.email.hasError ||
			fields.value.feedback.hasError;

        errorHTML.value = 'Не заполнено поле'
	}

	watch(() => fields.value.fio.fieldValue, checkFIO);
	watch(() => fields.value.email.fieldValue, checkEmail);
	watch(() => fields.value.feedback.fieldValue, checkFeedback);
	watchEffect(updateAllowSubmit);
	watchEffect(updateShowError);

	async function formSubmit() {
		let form = document.getElementById('form');

		let response = await fetch('/api/guest-book/form', {
			method: 'POST',
            headers: {
                'Accept': 'text/plain'
            },
			body: new FormData(form),
		});

        errorHTML.value = await response.text();
        showError.value = true;

        await getFeedbackList();
	}

    async function getFeedbackList() {
        let response = await fetch('/api/guest-book/feedback', {
            headers: {
                'Accept': 'application/json'
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

	return { fields, showError, errorHTML, formdata, feedbackList, formSubmit };
});
