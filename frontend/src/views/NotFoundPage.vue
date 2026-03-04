<script setup>
import { useRoute } from 'vue-router';

const route = useRoute();
</script>

<template>
	<div class="flex h-full flex-col items-center justify-center space-y-10">
		<h2 class="text-center text-3xl font-bold">Страница "{{ route.fullPath }}" не найдена</h2>
		<RouterLink :to="{ name: 'Main' }" class="rounded-sm border bg-neutral-300 p-1"
			>Вернуться на главную</RouterLink
		>
	</div>
</template>
