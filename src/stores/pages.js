import { defineStore } from 'pinia';
import { useRoute } from 'vue-router';
import { ref } from 'vue';

export const usePagesStore = defineStore('Pages', () => {
	const route = useRoute();

	function isCurrentPage() {
		return this.route === route.path;
	}

	const pages = ref([
		{ route: '/', text: 'Главная', isCurrentPage: isCurrentPage },
		{ route: '/aboutme', text: 'Обо мне', isCurrentPage: isCurrentPage },
		{ route: '/myinterests', text: 'Мои интересы', isCurrentPage: isCurrentPage },
		{ route: '/study', text: 'Учеба', isCurrentPage: isCurrentPage },
		{ route: '/photoalbum', text: 'Фотоальбом', isCurrentPage: isCurrentPage },
		{ route: '/contact', text: 'Контакт', isCurrentPage: isCurrentPage },
		{ route: '/test', text: 'Тест по дисциплине', isCurrentPage: isCurrentPage },
		{ route: '/history', text: 'История просмотра', isCurrentPage: isCurrentPage },
	]);

	return { pages };
});
