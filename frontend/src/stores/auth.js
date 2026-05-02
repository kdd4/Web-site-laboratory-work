import { defineStore } from 'pinia';
import { ref, watch, watchEffect } from 'vue';
import { useRouter } from 'vue-router';

export const useAuthStore = defineStore('auth', () => {
	const router = useRouter();

	async function checkAuth() {
		let response = await fetch('/api/auth/status', {
			headers: {
				Accept: 'application/json',
			},
		});

		if (!response.ok) {
			return false;
		}

		let jsonResponse = await response.json();

		let result = jsonResponse.auth ?? false;

		return result;
	}

	async function roles() {
		let response = await fetch('/api/auth/roles', {
			headers: {
				Accept: 'application/json',
			},
		});

		if (!response.ok) {
			return false;
		}

		let jsonResponse = await response.json();

		return jsonResponse.roles;
	}

	async function logout() {
		let response = await fetch('/api/auth/logout', {
			method: 'POST',
			headers: {
				Accept: 'application/json',
			},
		});

		router.push({ name: 'Auth' });

		return response.ok;
	}

	const register = ref(false);

	const showError = ref(false);
	const allowSubmit = ref(false);

	const errorHTML = ref('');

	const formdata = ref({
		allowSubmit: allowSubmit,
	});

	const fields = ref({
		login: {
			label: 'Логин',
			type: 'text',
			name: 'login',
			placeholder: 'Введите логин',
			fieldValue: '',
			hasError: false,
			isCorrect: false,
		},
		password: {
			label: 'Пароль',
			type: 'text',
			name: 'password',
			placeholder: 'Введите пароль',
			fieldValue: '',
			hasError: false,
			isCorrect: false,
		},
	});

	function checkLogin() {
		fields.value.login.hasError = !fields.value.login.fieldValue;
		fields.value.login.isCorrect = !fields.value.login.hasError;
	}

	function checkPassword() {
		fields.value.password.hasError = !fields.value.password.fieldValue;
		fields.value.password.isCorrect = !fields.value.password.hasError;
	}

	function updateAllowSubmit() {
		allowSubmit.value = fields.value.login.isCorrect && fields.value.password.isCorrect;
	}

	function updateShowError() {
		showError.value = fields.value.login.hasError || fields.value.password.hasError;

		errorHTML.value = 'Заполните все поля';
	}

	watch(() => fields.value.login.fieldValue, checkLogin);
	watch(() => fields.value.password.fieldValue, checkPassword);
	watchEffect(updateAllowSubmit);
	watchEffect(updateShowError);

	async function formSubmit() {
		let form = document.getElementById('form');

		let endpoint = register.value ? '/api/auth/register' : '/api/auth/login';

		let response = await fetch(endpoint, {
			method: 'POST',
			headers: {
				Accept: 'text/plain',
			},
			body: new FormData(form),
		});

		if (!response.ok) {
			errorHTML.value = await response.text();
			showError.value = true;
			return;
		}

		router.push({ name: 'Main' });
	}

	const form = ref({
		id: 'form',
		fields,
		formdata,
		showError,
		errorHTML,
		submit: formSubmit,
		register,
	});

	return { form, formSubmit, checkAuth, logout, roles };
});
