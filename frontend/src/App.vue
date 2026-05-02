<script setup>
import { useRoute, RouterView, useRouter } from 'vue-router';
import { watch } from 'vue';

import { useVisitsStore } from './stores/visits';
import Navigation from './components/NavigationBlock.vue';
import { useAuthStore } from './stores/auth';

const route = useRoute();
const router = useRouter();
const auth = useAuthStore();

let visitsStore = useVisitsStore();

watch(route, () => visitsStore.visitPage(route.name));

watch(route, async (r) => {
	if (r.name === 'Auth') return;

	if (!(await auth.checkAuth())) {
		router.push({ name: 'Auth' });
		return;
	}
});
</script>

<template>
	<Navigation v-if="route.name !== 'Auth'" />

	<RouterView />
</template>
