import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
	history: createWebHistory(import.meta.env.BASE_URL),
	routes: [
		{
			path: '/',
			name: 'Main',
			component: () => import('@/views/Main.vue'),
		},
		{
			path: '/aboutme',
			name: 'AboutMe',
			component: () => import('@/views/AboutMe.vue'),
		},
		{
			path: '/myinterests',
			name: 'MyInterests',
			component: () => import('@/views/MyInterests.vue'),
		},
		{
			path: '/study',
			name: 'Study',
			component: () => import('@/views/Study.vue'),
		},
		{
			path: '/photoalbum',
			name: 'PhotoAlbum',
			component: () => import('@/views/PhotoAlbum.vue'),
		},
		{
			path: '/contact',
			name: 'Contact',
			component: () => import('@/views/Contact.vue'),
		},
		{
			path: '/test',
			name: 'Test',
			component: () => import('@/views/Test.vue'),
		},
	],
})

export default router
