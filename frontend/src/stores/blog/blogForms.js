import { defineStore, storeToRefs } from 'pinia';
import { ref, watch, watchEffect } from 'vue';
import { useAuthStore } from '../auth';
import { useBlogStore } from './blog';

export const useBlogFormsStore = defineStore('blogForms', () => {
	const blog = useBlogStore();

	const auth = useAuthStore();
	const { isAuth, isAdmin } = storeToRefs(auth);

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
			name: 'posts',
			accept: '.csv',
			change: (l) => (fileAllowSubmit.value = l.length != 0),
			hasError: false,
			isCorrect: false,
		},
	});

	async function fileSubmit() {
		let form = document.getElementById('fileForm');

		let response = await fetch('/api-laravel/blog/file', {
			method: 'POST',
			body: new FormData(form),
		});

		let responseJSON = await response.json();

		blogErrorHTML.value = responseJSON.result ? 'Ok' : responseJSON.error;
		blogShowError.value = true;

		await blog.getBlogPosts();
	}

	const blogAllowSubmit = ref(false);
	const blogShowError = ref(false);
	const blogErrorHTML = ref('');

	const blogFormData = ref({
		allowSubmit: blogAllowSubmit,
	});

	const blogFields = ref({
		fio: {
			label: 'ФИО',
			type: 'text',
			name: 'fio',
			placeholder: 'Введите ФИО',
			fieldValue: '',
			hasError: false,
			isCorrect: false,
		},
		theme: {
			label: 'Тема',
			type: 'text',
			name: 'theme',
			placeholder: 'Введите тему',
			fieldValue: '',
			hasError: false,
			isCorrect: false,
		},
		image: {
			label: 'Фото',
			type: 'file',
			name: 'image',
			accept: 'image/*',
			change: function (l) {
				this.isCorrect = l.length != 0;
			},
			hasError: false,
			isCorrect: false,
		},
		text: {
			label: 'Текст',
			type: 'textarea',
			name: 'text',
			placeholder: 'Введите текст',
			fieldValue: '',
			hasError: false,
			isCorrect: false,
		},
	});

	async function blogSubmit() {
		let form = document.getElementById('blogForm');

		let response = await fetch('/api-laravel/blog', {
			method: 'POST',
			headers: {
				Accept: 'text/plain',
			},
			body: new FormData(form),
		});

		let responseJSON = await response.json();

		blogErrorHTML.value = responseJSON.result ? 'Ok' : responseJSON.error;
		blogShowError.value = true;

		await blog.getBlogPosts();
	}

	function checkFIO() {
		blogFields.value.fio.hasError = !blogFields.value.fio.fieldValue;
		blogFields.value.fio.isCorrect = !blogFields.value.fio.hasError;
	}

	function checkTheme() {
		blogFields.value.theme.hasError = !blogFields.value.theme.fieldValue;
		blogFields.value.theme.isCorrect = !blogFields.value.theme.hasError;
	}

	function checkText() {
		blogFields.value.text.hasError = !blogFields.value.text.fieldValue;
		blogFields.value.text.isCorrect = !blogFields.value.text.hasError;
	}

	function updateAllowSubmit() {
		blogAllowSubmit.value = blogFields.value.theme.isCorrect && blogFields.value.text.isCorrect;
	}

	function updateShowError() {
		blogShowError.value = blogFields.value.theme.hasError || blogFields.value.text.hasError;

		blogErrorHTML.value = 'Не заполнено поле';
	}

	watch(() => blogFields.value.fio.fieldValue, checkFIO);
	watch(() => blogFields.value.theme.fieldValue, checkTheme);
	watch(() => blogFields.value.text.fieldValue, checkText);
	watchEffect(updateAllowSubmit);
	watchEffect(updateShowError);

	const forms = ref([
		{
			id: 'blogForm',
			fields: blogFields,
			formdata: blogFormData,
			showError: blogShowError,
			errorHTML: blogErrorHTML,
			submit: blogSubmit,
			show: isAuth,
		},
		{
			id: 'fileForm',
			fields: fileFields,
			formdata: fileFormData,
			showError: fileShowError,
			errorHTML: fileErrorHTML,
			submit: fileSubmit,
			show: isAdmin,
		},
	]);

	return {
		forms,
	};
});
