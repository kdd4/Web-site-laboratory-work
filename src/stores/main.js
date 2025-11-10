import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useMainStore = defineStore('main', () => {
	const headers = ref([
		{ text: 'Камышов\nДаниил\nДенисович', class: 'order-1' },
		{ text: 'ИС/б-23-2-о\nЛаборатороная работа №3', class: 'order-3' },
	]);

	return { headers };
});
