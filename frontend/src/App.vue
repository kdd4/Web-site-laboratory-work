<script setup>
import { useRoute, RouterView } from 'vue-router';
import { ref, watch } from 'vue';

import { useVisitsStore } from './stores/visits';
import Navigation from './components/NavigationBlock.vue';
import { useAuthStore } from './stores/auth';
import { storeToRefs } from 'pinia';

const route = useRoute();
const auth = useAuthStore();
let visitsStore = useVisitsStore();

const { isAuth } = storeToRefs(auth);

watch(route, () => visitsStore.visitPage(route.name));
watch(route, auth.updateStatus);

const fio = ref('');

function loadFIO() {
	if (!isAuth.value) {
		fio.value = '';
		return;
	}

	auth.getInfo().then((res) => (fio.value = res.fio));
}
loadFIO();

watch(isAuth, loadFIO);
</script>

<template>
	<Navigation v-if="route.name !== 'Auth'" />

	<RouterView />

	<div
		v-if="fio !== '' && route.name !== 'Auth'"
		class="fixed bottom-0 rounded-tr-lg border bg-neutral-100 p-1 not-sm:hidden"
	>
		Пользователь: {{ fio }}
	</div>
</template>
