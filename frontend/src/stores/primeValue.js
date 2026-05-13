import { defineStore } from 'pinia';
import { ref, watch, watchEffect } from 'vue';

export const usePrimeValueStore = defineStore('primeValue', () => {
	const id = ref(null);
	const status = ref('');

	const showError = ref(false);
	const allowSubmit = ref(false);

	const errorHTML = ref('');

	const formdata = ref({
		allowSubmit: allowSubmit,
	});

	const fields = ref({
		length: {
			label: 'Битность',
			type: 'text',
			name: 'length',
			placeholder: 'Введите размер числа',
			fieldValue: '',
			hasError: false,
			isCorrect: false,
		},
	});

	function checkLength() {
		fields.value.length.hasError = !fields.value.length.fieldValue;
		fields.value.length.isCorrect = !fields.value.length.hasError;
	}

	function updateAllowSubmit() {
		allowSubmit.value = fields.value.length.isCorrect;
	}

	function updateShowError() {
		showError.value = fields.value.length.hasError;

		errorHTML.value = 'Введите длину';
	}

	watch(() => fields.value.length.fieldValue, checkLength);
	watchEffect(updateAllowSubmit);
	watchEffect(updateShowError);

	let checkInterval = null;

	async function check() {
		if (id.value === null) {
			return;
		}

		let response = await fetch(`/api/prime/result?id=${id.value}`, {
			headers: {
				Accept: 'application/json',
			},
		});

		if (!response.ok) {
			status.value = 'error';
			errorHTML.value = 'Ошибка проверки статуса';
			showError.value = true;

			id.value = null;
			return;
		}

		let data = await response.json();

		if (data.result === null) {
			return;
		}

		id.value = null;

		if (data.result === 'failed') {
			status.value = 'error';
			errorHTML.value = 'Неудача';
			showError.value = true;
			return;
		}

		status.value = 'good';
		errorHTML.value = data.result;
		showError.value = true;
	}

	async function generate() {
		showError.value = false;

		let form = document.getElementById('form');

		let response = await fetch('/api/prime/generate', {
			method: 'POST',
			headers: {
				Accept: 'application/json',
			},
			body: new FormData(form),
		});

		if (!response.ok) {
			status.value = 'error';
			errorHTML.value = 'Ошибка отправки запроса';
			showError.value = true;
			return;
		}

		let data = await response.json();

		id.value = data.id;

		status.value = 'waiting';
		errorHTML.value = 'Рассчёт';
		showError.value = true;

		checkInterval = setInterval(check, 1000);
	}

	watch(id, (val) => (val === null ? clearInterval(checkInterval) : null));

	return { fields, showError, errorHTML, formdata, status, generate };
});
