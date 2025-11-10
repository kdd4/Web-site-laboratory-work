import { defineStore } from 'pinia';
import { useRoute } from 'vue-router';
import { ref } from 'vue';

export const usePagesStore = defineStore('pages', () => {
	const route = useRoute();

	function isCurrentPage() {
		return this.route === route.path;
	}

	const pages = ref([
		{ route: '/', text: 'Главная', isCurrentPage },
		{ route: '/aboutme', text: 'Обо мне', isCurrentPage },
		{ route: '/myinterests', text: 'Мои интересы', isCurrentPage },
		{ route: '/study', text: 'Учеба', isCurrentPage },
		{ route: '/photoalbum', text: 'Фотоальбом', isCurrentPage },
		{ route: '/contact', text: 'Контакт', isCurrentPage },
		{ route: '/test', text: 'Тест по дисциплине', isCurrentPage },
		{ route: '/history', text: 'История просмотра', isCurrentPage },
	]);

	return { pages };
});
