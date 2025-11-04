<script setup>
import { ref } from 'vue';

const headers = ref([
	{ text: 'Камышов\nДаниил\nДенисович', class: 'order-1' },
	{ text: 'ИС/б-23-2-о\nЛаборатороная работа №3', class: 'order-3' },
]);

const flex_col = ref(false);

function pageDirection(event) {
	flex_col.value = window.innerWidth <= 760; // px
}

window.addEventListener('resize', pageDirection, { passive: true });
pageDirection();
</script>

<template>
	<main :class="{ 'flex-col': flex_col }" class="flex w-auto items-center justify-center">
		<h2 v-for="elem in headers" class="text-center text-2xl font-bold" :class="elem.class">
			<pre>{{ elem.text }}</pre>
		</h2>
		<img
			class="order-2 mx-3 w-70 transition-all duration-500 ease-in-out hover:rotate-x-45 hover:rotate-y-45"
			src="/src/assets/images/me.jpg"
			alt="Моя фотография"
		/>
	</main>
</template>
