import { defineStore } from 'pinia';
import { useRoute } from 'vue-router';
import { ref } from 'vue';

export const usePagesStore = defineStore('pages', () => {
	const route = useRoute();

	function isCurrentPage() {
		return this.name === route.name;
	}

	const pages = ref([
		{ name: 'Main', text: 'Главная', isCurrentPage },
		{ name: 'AboutMe', text: 'Обо мне', isCurrentPage },
		{ name: 'MyInterests', text: 'Мои интересы', isCurrentPage },
		{ name: 'Study', text: 'Учеба', isCurrentPage },
		{ name: 'PhotoAlbum', text: 'Фотоальбом', isCurrentPage },
		{ name: 'Contact', text: 'Контакт', isCurrentPage },
		{ name: 'MathTest', text: 'Тест по дисциплине', isCurrentPage },
		{ name: 'History', text: 'История просмотра', isCurrentPage },
	]);

	return { pages };
});
