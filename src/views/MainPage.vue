<script setup>
import { storeToRefs } from 'pinia';
import { useMainStore } from '@/stores/main';

const mainStore = useMainStore();
const { headers } = storeToRefs(mainStore);
</script>

<template>
	<main class="flex w-auto flex-col items-center justify-center md:flex-row">
		<h2
			v-for="(elem, ind) in headers"
			:key="ind"
			class="text-center text-2xl font-bold"
			:class="elem.class"
		>
			<pre>{{ elem.text }}</pre>
		</h2>
		<img
			class="order-2 mx-3 w-70 transition-all duration-500 ease-in-out hover:rotate-x-45 hover:rotate-y-45"
			src="/src/assets/images/me.jpg"
			alt="Моя фотография"
		/>
	</main>
</template>
