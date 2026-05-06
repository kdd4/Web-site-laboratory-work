import { defineStore, storeToRefs } from 'pinia';
import { useRoute } from 'vue-router';
import { ref } from 'vue';
import { useAuthStore } from './auth';

export const usePagesStore = defineStore('pages', () => {
	const route = useRoute();
	const auth = useAuthStore();

	const { isAdmin } = storeToRefs(auth);

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
		{ name: 'Blog', text: 'Блог', isCurrentPage },
		{ name: 'GuestBook', text: 'Гостевая книга', isCurrentPage },
		{ name: 'History', text: 'История просмотра', isCurrentPage },
		{ name: 'Activities', text: 'Активность пользователей', isCurrentPage, show: isAdmin },
	]);

	return { pages };
});
