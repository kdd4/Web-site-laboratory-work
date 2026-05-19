import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useBlogCommentsStore = defineStore('blogComments', () => {
	const id = ref(null);
	const comments = ref([]);

	async function update(curId) {
		let response = await fetch(`/api-laravel/blog/comments/${curId}`);

		let list = await response.json();

		if (!list.length) {
			comments.value = [];
			return;
		}

		comments.value = list;

		comments.value.sort((a, b) => new Date(b.time) - new Date(a.time));
	}

	async function open(curId) {
		if (id.value === curId) {
			id.value = null;
			return;
		}
		id.value = null;

		await update(curId);

		id.value = curId;
	}

	async function post() {
		let form = document.getElementById('commentForm');
		let formdata = new FormData(form);

		if (formdata.get('text') === '') {
			return;
		}

		formdata.append('blogID', id.value);

		await fetch('/api-laravel/blog/comment', {
			method: 'POST',
			body: formdata,
		});

		await update(id.value);
	}

	return {
		id,
		comments,
		open,
		post,
	};
});
