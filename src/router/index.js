import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
	history: createWebHistory(import.meta.env.BASE_URL),
	routes: [
		{
			path: '/',
			name: 'Main',
			component: () => import('@/views/MainPage.vue'),
		},
		{
			path: '/aboutme',
			name: 'AboutMe',
			component: () => import('@/views/AboutMePage.vue'),
		},
		{
			path: '/myinterests',
			name: 'MyInterests',
			component: () => import('@/views/MyInterestsPage.vue'),
		},
		{
			path: '/study',
			name: 'Study',
			component: () => import('@/views/StudyPage.vue'),
		},
		{
			path: '/photoalbum',
			name: 'PhotoAlbum',
			component: () => import('@/views/PhotoAlbumPage.vue'),
		},
		{
			path: '/contact',
			name: 'Contact',
			component: () => import('@/views/ContactPage.vue'),
		},
		{
			path: '/test',
			name: 'MathTest',
			component: () => import('@/views/MathTestPage.vue'),
		},
		{
			path: '/history',
			name: 'History',
			component: () => import('@/views/HistoryPage.vue'),
		},
	],
});

export default router;
