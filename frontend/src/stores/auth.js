import { defineStore } from 'pinia';
import { computed, ref, toRefs, watch, watchEffect } from 'vue';
import { useRouter } from 'vue-router';

export const useAuthStore = defineStore('auth', () => {
	const router = useRouter();

	const isAuth = ref(false);
	const isAdmin = ref(false);

	async function updateIsAdmin() {
		let res = await getRoles();

		isAdmin.value = res.includes('admin');
	}

	async function updateStatus() {
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

		if (result) {
			updateIsAdmin();
		}

		isAuth.value = result;

		return result;
	}

	async function getRoles() {
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

	async function getInfo() {
		let response = await fetch('/api/auth/info', {
			headers: {
				Accept: 'application/json',
			},
		});

		if (!response.ok) {
			return false;
		}

		let jsonResponse = await response.json();

		return jsonResponse;
	}

	async function logout() {
		let response = await fetch('/api/auth/logout', {
			method: 'POST',
			headers: {
				Accept: 'application/json',
			},
		});

		isAuth.value = false;
		isAdmin.value = false;

		router.push({ name: 'Main' });

		return response.ok;
	}

	const register = ref(false);

	const showError = ref(false);
	const allowSubmit = ref(false);

	const errorHTML = ref('');

	const formdata = ref({
		allowSubmit: allowSubmit,
		submitText: computed(() => (register.value ? 'Зарегистрироваться' : 'Войти')),
	});

	const fieldsFull = ref({
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
			type: 'password',
			name: 'password',
			placeholder: 'Введите пароль',
			fieldValue: '',
			hasError: false,
			isCorrect: false,
		},
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
	});

	const fields = computed(function () {
		const { login, password, fio, email } = fieldsFull.value;

		return register.value ? { login, password, fio, email } : { login, password };
	});

	function checkLogin() {
		fieldsFull.value.login.hasError = !fieldsFull.value.login.fieldValue;
		fieldsFull.value.login.isCorrect = !fieldsFull.value.login.hasError;
	}

	function checkPassword() {
		fieldsFull.value.password.hasError = !fieldsFull.value.password.fieldValue;
		fieldsFull.value.password.isCorrect = !fieldsFull.value.password.hasError;
	}

	function checkFIO() {
		if (!register.value) return;

		fieldsFull.value.fio.hasError = !fieldsFull.value.fio.fieldValue;
		fieldsFull.value.fio.isCorrect = !fieldsFull.value.fio.hasError;
	}

	function checkEmail() {
		if (!register.value) return;

		fieldsFull.value.email.hasError = !fieldsFull.value.email.fieldValue;
		fieldsFull.value.email.isCorrect = !fieldsFull.value.email.hasError;
	}

	function updateAllowSubmit() {
		allowSubmit.value =
			fieldsFull.value.login.isCorrect &&
			fieldsFull.value.password.isCorrect &&
			((fieldsFull.value.fio.isCorrect && fieldsFull.value.email.isCorrect) || !register.value);
	}

	function updateShowError() {
		showError.value =
			fieldsFull.value.login.hasError ||
			fieldsFull.value.password.hasError ||
			((fieldsFull.value.fio.hasError || fieldsFull.value.email.hasError) && register.value);

		errorHTML.value = 'Заполните все поля';
	}

	watch(() => fieldsFull.value.login.fieldValue, checkLogin);
	watch(() => fieldsFull.value.password.fieldValue, checkPassword);
	watch(() => fieldsFull.value.fio.fieldValue, checkFIO);
	watch(() => fieldsFull.value.email.fieldValue, checkEmail);
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

		fields.value.password.fieldValue = '';

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

	return { form, formSubmit, logout, getRoles, getInfo, isAuth, isAdmin, updateStatus };
});
