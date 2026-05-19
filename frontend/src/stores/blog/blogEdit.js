import { defineStore } from 'pinia';
import { ref, watch, watchEffect } from 'vue';
import { useBlogStore } from './blog';

export const useBlogEditStore = defineStore('blogEdit', () => {
	const blog = useBlogStore();

	const show = ref(false);
	const id = ref(null);
	const text = ref('');

	const allowSubmit = ref(false);
	const showError = ref(false);
	const errorHTML = ref('');

	const formData = ref({
		allowSubmit: allowSubmit,
	});

	const editFields = ref({
		text: {
			label: 'Текст',
			type: 'textarea',
			name: 'text',
			placeholder: 'Введите текст',
			fieldValue: text,
			hasError: false,
		},
	});

	async function editSubmit() {
		let json = JSON.stringify({
			id: id.value,
			text: text.value,
		});

		let response = await fetch('/api-laravel/blog', {
			method: 'PUT',
			headers: {
				'Content-Type': 'application/json',
			},
			body: json,
		});

		let responseJSON = await response.json();

		show.value = !responseJSON.result;

		if (!responseJSON.result) {
			errorHTML.value = responseJSON.error;
			showError.value = true;
		}

		await blog.getBlogPosts();
	}

	function checkText() {
		editFields.value.text.hasError = !editFields.value.text.fieldValue;
	}

	function updateAllowSubmit() {
		allowSubmit.value = !editFields.value.text.hasError;
	}

	function updateShowError() {
		showError.value = editFields.value.text.hasError;

		errorHTML.value = 'Не заполнено поле';
	}

	watch(() => editFields.value.text.fieldValue, checkText);
	watchEffect(updateAllowSubmit);
	watchEffect(updateShowError);

	function open(curId, curText) {
		id.value = curId;
		text.value = curText;
		show.value = true;
	}

	function close() {
		id.value = null;
		show.value = false;

		showError.value = false;
	}

	const forms = ref([
		{
			id: 'editBlogForm',
			fields: editFields,
			formdata: formData,
			showError: showError,
			errorHTML: errorHTML,
			submit: editSubmit,
		},
	]);

	return {
		forms,
		show,
		open,
		close,
	};
});
