import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useMyInterestsStore = defineStore('myInterests', () => {
	const blocks = ref([]);

	fetch('/api/my-interests/interests', {
		headers: {
			Accept: 'application/json',
		},
	})
		.then((response) => response.json())
		.then((response) => (blocks.value = response));

	return { blocks };
});
