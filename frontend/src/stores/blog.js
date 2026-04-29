import { defineStore } from 'pinia';
import { computed, ref, watch, watchEffect } from 'vue';

export const useBlogStore = defineStore('blog', () => {
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

		let response = await fetch('/api/blog/postfile', {
			method: 'POST',
			headers: {
				Accept: 'text/plain',
			},
			body: new FormData(form),
		});

		fileErrorHTML.value = await response.text();
		fileShowError.value = true;

		await getBlogPosts();
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

		let response = await fetch('/api/blog/post', {
			method: 'POST',
			headers: {
				Accept: 'text/plain',
			},
			body: new FormData(form),
		});

		blogErrorHTML.value = await response.text();
		blogShowError.value = true;

		await getBlogPosts();
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

	async function getBlogPosts() {
		let response = await fetch('/api/blog/posts', {
			headers: {
				Accept: 'application/json',
			},
		});

		let list = await response.json();

		if (!list.length) {
			blogPosts.value = [];
			return;
		}

		blogPosts.value = list;

	    blogPosts.value.sort((a, b) => new Date(b.time) - new Date(a.time));
	}

	getBlogPosts();

	const forms = ref([
		{
			id: 'blogForm',
			fields: blogFields,
			formdata: blogFormData,
			showError: blogShowError,
			errorHTML: blogErrorHTML,
			submit: blogSubmit,
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

	const blogPosts = ref([]);

	const pageSize = ref(5);
	const page = ref(0);

	const pageCount = computed(() => Math.ceil(blogPosts.value.length / pageSize.value));
	const blogPage = computed(() =>
		blogPosts.value.slice(page.value * pageSize.value, (page.value + 1) * pageSize.value),
	);

	const pageListSize = ref(5);
	const pageList = computed(function () {
		let lowLimit = Math.max(page.value - Math.floor(pageListSize.value / 2), 0);
		let highLimit = Math.max(pageCount.value - pageListSize.value, 0);
		let length = Math.min(pageCount.value, pageListSize.value);

		return Array.from({ length }, (_, k) => Math.min(lowLimit, highLimit) + k);
	});

	const firstPageShow = computed(() => !pageList.value.includes(0));
	const lastPageShow = computed(() => !pageList.value.includes(pageCount.value - 1));

	function goToFirstPage() {
		page.value = 0;
	}

	function goToPage(newPage) {
		page.value = newPage;
	}

	function goToLastPage() {
		page.value = pageCount.value - 1;
	}

	return {
		forms,
		blogPage,
		page,
		pageList,
		firstPageShow,
		lastPageShow,
		goToFirstPage,
		goToPage,
		goToLastPage,
	};
});
