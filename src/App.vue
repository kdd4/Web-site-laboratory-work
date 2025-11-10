<script setup>
import { useRoute, RouterView } from 'vue-router';
import { watch } from 'vue';

import { useVisitsStore } from './stores/visits';
import Navigation from './components/Navigation.vue';

const route = useRoute();

let visitsStore = useVisitsStore();

watch(route, () => visitsStore.visitPage(route.path));
</script>

<template>
	<Navigation />

	<RouterView />
</template>
